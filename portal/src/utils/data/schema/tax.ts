import * as yup from "yup";

export const taxFormSchema = yup
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
        value: yup
            .number()
            .typeError("Value must contain numbers only")
            .min(0, "Value cannot be negative")
            .max(100, "Value cannot be greater than 100")
            .required("Value is required"),
        is_inter_state_tax: yup
            .boolean()
            .typeError("Is Inter State Tax must contain boolean only")
            .optional()
            .default(false),
        is_active: yup
            .boolean()
            .typeError("Is Active must contain boolean only")
            .optional()
            .default(true),
    })
    .required();


export type TaxFormValuesType = yup.InferType<
    typeof taxFormSchema
>;