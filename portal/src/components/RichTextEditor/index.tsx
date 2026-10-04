import { useToast } from "@/hooks/useToast";
import { useTextEditorImageUploadMutation } from "@/utils/data/mutation/text_editor_image";
import {
  textEditorImageFormSchema,
  type TextEditorImageFormValuesType,
} from "@/utils/data/schema/text_editor_image";
import { yupResolver } from "@hookform/resolvers/yup";
import { useCallback, useMemo, useRef } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import ReactQuill from "react-quill-new";
import "react-quill-new/dist/quill.snow.css";
import { FieldError } from "../ui/field";
import { handleFormServerErrors } from "@/utils/helper";

interface RichTextEditorProps {
  value: string;
  onChange: (value: string) => void;
  onChangePlainText?: (value: string) => void;
  placeholder?: string;
  disabled?: boolean;
}

const ACCEPTED_IMAGE_TYPES = [
  "image/jpeg",
  "image/png",
  "image/webp",
  "image/gif",
];

const FORM_DEFAULT_VALUES: TextEditorImageFormValuesType = {
  image: undefined,
};

const RichTextEditor = ({
  value,
  onChange,
  onChangePlainText,
  placeholder = "Write something...",
  disabled = false,
}: RichTextEditorProps) => {
  const quillRef = useRef<ReactQuill>(null);

  const { toastError } = useToast();
  const uploadMutation = useTextEditorImageUploadMutation();

  const form = useForm({
    resolver: yupResolver(
      textEditorImageFormSchema,
    ) as Resolver<TextEditorImageFormValuesType>,
    defaultValues: FORM_DEFAULT_VALUES,
  });

  /**
   * Upload image to server
   */
  const uploadImage = useCallback(
    async (file: File): Promise<string> => {
      const response = await uploadMutation.mutateAsync(
        {
          image: file,
        },
        {
          onError: (error) => {
            handleFormServerErrors(
              error,
              form as UseFormReturn<TextEditorImageFormValuesType>,
            );
          },
        },
      );

      if (!response?.image_url) {
        throw new Error("Image URL was not returned");
      }

      return response.image_url;
    },
    [uploadMutation.mutateAsync, form],
  );

  const handleImageSubmit = useCallback(
    async (values: TextEditorImageFormValuesType): Promise<void> => {
      const editor = quillRef.current?.getEditor();

      if (!editor || !values.image) {
        return;
      }

      const selection = editor.getSelection(true);
      const index = selection?.index ?? editor.getLength();

      try {
        const imageUrl = await uploadImage(values.image as File);

        const currentEditor = quillRef.current?.getEditor();

        if (!currentEditor) {
          return;
        }

        currentEditor.insertEmbed(index, "image", imageUrl, "user");

        currentEditor.setSelection(index + 1, 0, "user");
      } catch (error) {
        toastError("Failed to upload image.");
      }
    },
    [uploadImage, toastError],
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

      /**
       * Put the file into React Hook Form.
       */
      form.setValue("image", file, {
        shouldDirty: true,
        shouldTouch: true,
      });

      /**
       * handleSubmit returns a function.
       *
       * Calling () actually executes validation + submit.
       */
      await form.handleSubmit((values) => {
        handleImageSubmit(values);
      })();
    };
  }, [disabled, uploadMutation.isPending, handleImageSubmit, form]);

  const handleEditorChange = useCallback(
    (html: string) => {
      onChange(html);

      const editor = quillRef.current?.getEditor();

      if (!editor || !onChangePlainText) {
        return;
      }

      const plainText = editor.getText().trim();

      onChangePlainText(plainText);
    },
    [onChange, onChangePlainText],
  );

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
    <div className="relative overflow-hidden rounded-md border [&_.ql-editor]:min-h-56 [&_.ql-container]:min-h-56">
      <ReactQuill
        ref={quillRef}
        theme="snow"
        value={value}
        onChange={handleEditorChange}
        modules={modules}
        placeholder={placeholder}
        readOnly={disabled}
      />

      {form.formState.errors.image?.message && (
        <FieldError errors={[form.formState.errors.image]} />
      )}

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
