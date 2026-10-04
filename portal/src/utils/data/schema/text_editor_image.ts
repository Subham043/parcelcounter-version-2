import * as yup from "yup";

export const textEditorImageFormSchema = yup
    .object()
    .shape({
        image: yup
            .mixed()
            // eslint-disable-next-line @typescript-eslint/no-explicit-any
            .test("required", "Image is required", (value: any) => {
                return value !== undefined;
            })
            // eslint-disable-next-line @typescript-eslint/no-explicit-any
            .test("fileSize", "File size should be less than 2MB", (value: any) => {
                if (value !== undefined) {
                    return value.size <= 2000000;
                }
                return true;
            })
            // eslint-disable-next-line @typescript-eslint/no-explicit-any
            .test("fileFormat", "Please select a valid image", (value: any) => {
                if (value !== undefined) {
                    return ["image/png", "image/jpeg", "image/jpg", "image/webp"].includes(value.type);
                }
                return true;
            })
            .transform((value) => {
                if (value !== undefined) {
                    return value as Blob;
                }
                return undefined;
            }),
    })
    .required();


export type TextEditorImageFormValuesType = yup.InferType<
    typeof textEditorImageFormSchema
>;