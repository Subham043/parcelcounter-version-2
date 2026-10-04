import { stripHtml } from "@/utils/helper";
import * as yup from "yup";

export const legalContentFormSchema = yup
    .object()
    .shape({
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
        is_active: yup
            .boolean()
            .typeError("Is Active must contain boolean only")
            .optional()
            .default(true),
    })
    .required();


export type LegalContentFormValuesType = yup.InferType<
    typeof legalContentFormSchema
>;