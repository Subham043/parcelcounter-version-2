import { stripHtml } from "@/utils/helper";
import * as yup from "yup";

export const productFormSchema = yup
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
        hsn: yup
            .string()
            .typeError("HSN must contain characters only")
            .max(255, "HSN is too Long!")
            .optional(),
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
        brief_description: yup
            .string()
            .typeError("Brief Description must contain characters only")
            .max(500, "Brief Description is too Long!")
            .required("Brief Description is required"),
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
        min_cart_quantity: yup
            .number()
            .typeError("Min Cart Quantity must contain numbers only")
            .min(1, "Min Cart Quantity must be at least 1")
            .required("Min Cart Quantity is required"),
        cart_quantity_interval: yup
            .number()
            .typeError("Cart Quantity Interval must contain numbers only")
            .min(1, "Cart Quantity Interval must be at least 1")
            .required("Cart Quantity Interval is required"),
        cart_quantity_specification: yup
            .string()
            .typeError("Cart Quantity Specification must contain characters only")
            .max(255, "Cart Quantity Specification is too Long!")
            .required("Cart Quantity Specification is required"),
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
        sub_category: yup
            .array()
            .of(
                yup.object({
                    value: yup.number().required("Sub-Category is required"),
                    label: yup.string().required("Sub-Category is required"),
                }).required("Sub-Category is required")
            )
            .min(1, "Sub-Category is required")
            .required("Sub-Category is required"),
        tax: yup
            .array()
            .of(
                yup.object({
                    value: yup.number().required("Tax is required"),
                    label: yup.string().required("Tax is required"),
                }).required("Tax is required")
            )
            .min(1, "Tax is required")
            .required("Tax is required"),
        specifications: yup
            .array()
            .of(
                yup.object({
                    title: yup.string().max(255, "Specification title is too Long!").required("Specification title is required"),
                    description: yup.string().max(500, "Specification description is too Long!").required("Specification description is required"),
                }).required("Specification is required")
            )
            .min(1, "Specification is required")
            .required("Specification is required"),
        prices: yup
            .array()
            .of(
                yup.object({
                    min_quantity: yup.number().min(1, "Min Quantity must be at least 1").required("Min Quantity is required"),
                    price: yup.number().min(1, "Price must be at least 1").required("Price is required"),
                }).required("Price is required")
            )
            .min(1, "Price is required")
            .required("Price is required"),
        stocks: yup
            .array()
            .of(
                yup.object({
                    purchase_stock: yup.number().min(1, "Purchase Stock must be at least 1").required("Purchase Stock is required"),
                    quantity: yup.number().min(1, "Quantity must be at least 1").required("Quantity is required"),
                    purchased_at: yup.date().required("Purchased At is required"),
                }).required("Stock is required")
            )
            .min(1, "Stock is required")
            .required("Stock is required"),
        colors: yup
            .array()
            .of(
                yup.object({
                    name: yup.string().max(255, "Color name is too Long!").required("Color name is required"),
                    code: yup.string().max(255, "Color code is too Long!").required("Color code is required"),
                }).required("Color is required")
            )
            .optional()
            .default([]),
        videos: yup
            .array()
            .of(
                yup.object({
                    video: yup.string().url("Video URL is invalid").max(255, "Video URL is too Long!").required("Video URL is required"),
                }).required("Video is required")
            )
            .optional()
            .default([]),
        images: yup
            .array()
            .of(
                yup.object({
                    image: yup.mixed()
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
                }).required("Image is required")
            )
            .optional()
            .default([]),
        is_active: yup
            .boolean()
            .typeError("Is Active must contain boolean only")
            .optional()
            .default(true),
        is_new: yup
            .boolean()
            .typeError("Is New must contain boolean only")
            .optional()
            .default(false),
        is_on_sale: yup
            .boolean()
            .typeError("Is On Sale must contain boolean only")
            .optional()
            .default(false),
        is_featured: yup
            .boolean()
            .typeError("Is Featured must contain boolean only")
            .optional()
            .default(false),
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


export type ProductFormValuesType = yup.InferType<
    typeof productFormSchema
>;