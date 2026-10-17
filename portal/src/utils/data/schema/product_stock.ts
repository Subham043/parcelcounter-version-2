import * as yup from "yup";

export const productStockFormSchema = yup
    .object()
    .shape({
        purchase_stock: yup.number().min(1, "Purchase Stock must be at least 1").required("Purchase Stock is required"),
        quantity: yup.number().min(1, "Quantity must be at least 1").required("Quantity is required"),
        purchased_at: yup.date().required("Purchased At is required"),
    })
    .required();


export type ProductStockFormValuesType = yup.InferType<
    typeof productStockFormSchema
>;