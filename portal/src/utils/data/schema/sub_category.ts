import { stripHtml } from "@/utils/helper";
import * as yup from "yup";

export const subCategoryFormSchema = yup
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
        slug: yup
            .string()
            .typeError("Slug must contain characters only")
            .max(255, "Slug is too Long!")
            .required("Slug is required"),
        heading: yup
            .string()
            .typeError("Heading must contain characters only")
            .max(255, "Heading is too Long!")
            .required("Heading is required"),
        description: yup
            .string()
            .typeError("Description must contain characters only")
            .test(
                "not-empty",
                "Description is required",
                (value) => {
                    if (!value) return false;
                    const text = stripHtml(value);
                    return text.length > 0;
                }
            )
            .required("Description is required"),
        description_unfiltered: yup
            .string()
            .typeError("Description must contain characters only")
            .required("Description is required"),
        meta_title: yup
            .string()
            .typeError("Meta Title must contain characters only")
            .max(255, "Meta Title is too Long!")
            .optional(),
        meta_description: yup
            .string()
            .typeError("Meta Description must contain characters only")
            .max(500, "Meta Description is too Long!")
            .optional(),
        meta_keywords: yup
            .array()
            .of(
                yup.string()
                    .typeError("Meta Keywords must contain characters only")
                    .max(255, "Meta Keywords is too Long!")
            )
            .optional()
            .default([]),
        category: yup
            .array()
            .of(
                yup.object({
                    value: yup.number().required("Category is required"),
                    label: yup.string().required("Category is required"),
                }).required("Category is required")
            )
            .min(1, "Category is required")
            .required("Category is required"),
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


export type SubCategoryFormValuesType = yup.InferType<
    typeof subCategoryFormSchema
>;