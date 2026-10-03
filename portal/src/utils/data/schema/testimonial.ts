import * as yup from "yup";

export const testimonialFormSchema = yup
    .object()
    .shape({
        is_create: yup
            .boolean()
            .optional()
            .default(true),
        name: yup
            .string()
            .typeError("Name must contain characters only")
            .max(255, "Name is too Long!")
            .required("Name is required"),
        designation: yup
            .string()
            .typeError("Designation must contain characters only")
            .max(255, "Designation is too Long!")
            .required("Designation is required"),
        message: yup
            .string()
            .typeError("Message must contain characters only")
            .max(500, "Message is too Long!")
            .required("Message is required"),
        star: yup
            .number()
            .typeError("Star must contain numbers only")
            .min(1, "Star must be at least 1")
            .max(5, "Star must be at most 5")
            .required("Star is required"),
        is_active: yup
            .boolean()
            .typeError("Is Active must contain boolean only")
            .optional()
            .default(true),
        image: yup
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


export type TestimonialFormValuesType = yup.InferType<
    typeof testimonialFormSchema
>;