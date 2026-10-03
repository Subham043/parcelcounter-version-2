import * as yup from "yup";

export const bannerFormSchema = yup
    .object()
    .shape({
        is_create: yup
            .boolean()
            .optional()
            .default(true),
        title: yup
            .string()
            .typeError("Title must contain characters only")
            .max(255, "Title is too Long!")
            .optional(),
        alt: yup
            .string()
            .typeError("Alt must contain characters only")
            .max(255, "Alt is too Long!")
            .optional(),
        is_active: yup
            .boolean()
            .typeError("Is Active must contain boolean only")
            .optional()
            .default(true),
        desktop_image: yup
            .mixed()
            // eslint-disable-next-line @typescript-eslint/no-explicit-any
            .when("is_create", {
                is: true,
                then: (schema) => schema.test("required", "Image is required", (value: any) => {
                    return value !== undefined;
                }),
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
        mobile_image: yup
            .mixed()
            // eslint-disable-next-line @typescript-eslint/no-explicit-any
            .when("is_create", {
                is: true,
                then: (schema) => schema.test("required", "Image is required", (value: any) => {
                    return value !== undefined;
                }),
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


export type BannerFormValuesType = yup.InferType<
    typeof bannerFormSchema
>;