import { useToast } from "@/hooks/useToast";
import { useLessonUploadImageMutation } from "@/utils/data/mutation/lesson";
import { useCallback, useMemo, useRef } from "react";
import ReactQuill from "react-quill-new";
import "react-quill-new/dist/quill.snow.css";

interface RichTextEditorProps {
    value: string;
    onChange: (value: string) => void;
    placeholder?: string;
    disabled?: boolean;
}

const MAX_IMAGE_SIZE = 5 * 1024 * 1024;

const ACCEPTED_IMAGE_TYPES = [
    "image/jpeg",
    "image/png",
    "image/webp",
    "image/gif",
];

const RichTextEditor = ({
    value,
    onChange,
    placeholder = "Write something...",
    disabled = false,
}: RichTextEditorProps) => {
    const quillRef = useRef<ReactQuill>(null);

    const { toastError } = useToast();
    const uploadMutation = useLessonUploadImageMutation();

    /**
     * Upload image to server
     */
    const uploadImage = useCallback(
        async (file: File): Promise<string> => {
            const response = await uploadMutation.mutateAsync({
                upload: file,
            });

            if (!response?.url) {
                throw new Error("Image URL was not returned");
            }

            return response.url;
        },
        [uploadMutation.mutateAsync],
    );

    /**
     * Handle image upload from Quill toolbar
     */
    const handleImageUpload = useCallback(() => {
        if (disabled || uploadMutation.isPending) {
            return;
        }

        const input = document.createElement("input");

        input.type = "file";
        input.accept = ACCEPTED_IMAGE_TYPES.join(",");
        input.style.display = "none";

        document.body.appendChild(input);

        input.click();

        input.onchange = async () => {
            const file = input.files?.[0];

            // Remove temporary input
            input.remove();

            if (!file) {
                return;
            }

            /**
             * Validate MIME type
             */
            if (!ACCEPTED_IMAGE_TYPES.includes(file.type)) {
                toastError(
                    "Invalid image type. Please upload JPG, PNG, WEBP or GIF.",
                );

                return;
            }

            /**
             * Validate file size
             */
            if (file.size > MAX_IMAGE_SIZE) {
                toastError("Image size must be less than 5MB.");

                return;
            }

            /**
             * Make sure editor still exists
             */
            const editor = quillRef.current?.getEditor();

            if (!editor) {
                return;
            }

            /**
             * Save current selection BEFORE async upload.
             *
             * This is important because selection can become null
             * while the upload is happening.
             */
            const selection = editor.getSelection(true);

            const index = selection?.index ?? editor.getLength();

            try {
                const imageUrl = await uploadImage(file);

                /**
                 * Component/editor could have been unmounted
                 * while upload was running.
                 */
                const currentEditor = quillRef.current?.getEditor();

                if (!currentEditor) {
                    return;
                }

                /**
                 * Insert image at the position where the user
                 * originally had their cursor.
                 */
                currentEditor.insertEmbed(index, "image", imageUrl, "user");

                /**
                 * Move cursor after image.
                 */
                currentEditor.setSelection(index + 1, 0, "user");
            } catch (error) {
                console.error("Image upload failed:", error);

                toastError("Failed to upload image.");
            }
        };
    }, [disabled, uploadMutation.isPending, uploadImage]);

    /**
     * Quill configuration.
     *
     * useMemo prevents ReactQuill from receiving a new
     * modules object on every render.
     */
    const modules = useMemo(
        () => ({
            toolbar: {
                container: [
                    [{ header: [1, 2, 3, 4, 5, 6, false] }],

                    ["bold", "italic", "underline", "strike"],

                    [{ color: [] }, { background: [] }],

                    [{ align: [] }],

                    [{ list: "ordered" }, { list: "bullet" }],

                    [{ indent: "-1" }, { indent: "+1" }],

                    ["blockquote", "code-block"],

                    ["link", "image"],

                    ["clean"],
                ],

                handlers: {
                    image: handleImageUpload,
                },
            },
        }),
        [handleImageUpload],
    );

    return (
        <div className="relative overflow-hidden rounded-md border">
            <ReactQuill
                ref={quillRef}
                theme="snow"
                value={value}
                onChange={onChange}
                modules={modules}
                placeholder={placeholder}
                readOnly={disabled || uploadMutation.isPending}
            />

            {uploadMutation.isPending && (
                <div className="absolute inset-0 z-10 flex items-center justify-center bg-background/60 backdrop-blur-[1px]">
                    <div className="rounded-md border bg-background px-4 py-2 text-sm shadow-sm">
                        Uploading image...
                    </div>
                </div>
            )}
        </div>
    );
};

export default RichTextEditor;
