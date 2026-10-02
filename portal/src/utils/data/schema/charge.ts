import * as yup from "yup";

export const chargeFormSchema = yup
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
        is_percentage: yup
            .boolean()
            .typeError("Is Percentage must contain boolean only")
            .optional()
            .default(false),
        value: yup
            .number()
            .typeError("Value must contain numbers only")
            .min(0, "Value cannot be negative")
            .when('is_percentage', {
                is: true,
                then: (schema) => schema.max(100, "Value cannot be greater than 100")
            })
            .required("Value is required"),
        include_charges_for_cart_price_below: yup
            .number()
            .typeError("Include Charges for Cart Price Below must contain numbers only")
            .optional(),
        is_active: yup
            .boolean()
            .typeError("Is Active must contain boolean only")
            .optional()
            .default(true),
    })
    .required();


export type ChargeFormValuesType = yup.InferType<
    typeof chargeFormSchema
>;