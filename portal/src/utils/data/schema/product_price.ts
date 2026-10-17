import * as yup from "yup";

export const productPriceFormSchema = yup
    .object()
    .shape({
        min_quantity: yup.number().min(1, "Min Quantity must be at least 1").required("Min Quantity is required"),
        price: yup.number().min(1, "Price must be at least 1").required("Price is required"),
    })
    .required();


export type ProductPriceFormValuesType = yup.InferType<
    typeof productPriceFormSchema
>;