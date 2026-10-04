import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { TextEditorImageFormValuesType } from "../schema/text_editor_image";
import { createTextEditorImageHandler } from "../dal/text_editor_image";



export const useTextEditorImageUploadMutation = () => {
    const { toastError } = useToast();

    return useMutation({
        mutationFn: async (val: TextEditorImageFormValuesType) => {
            return await createTextEditorImageHandler(val);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Failed to upload Image.");
        },
    });
};