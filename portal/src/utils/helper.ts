import { type FieldValues, type UseFormReturn, type Path } from "react-hook-form";
import { isAxiosError } from "axios";
import { toastErrorFunc } from "@/hooks/useToast";


export function handleFormServerErrors<T extends FieldValues>(
    error: unknown,
    form: UseFormReturn<T>
) {
    if (!isAxiosError(error)) return;

    if (error.response?.data?.message) {
        toastErrorFunc(error.response.data.message);
    }

    const backendErrors = error.response?.data?.errors;
    if (!backendErrors) return;

    Object.entries(backendErrors).forEach(([key, messages]) => {
        const message = Array.isArray(messages) ? messages[0] : messages;

        form.setError(key as Path<T>, {
            type: "server",
            message,
        });
    });
}
