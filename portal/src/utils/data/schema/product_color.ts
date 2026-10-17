import * as yup from "yup";

export const productColorFormSchema = yup
    .object()
    .shape({
        name: yup.string().max(255, "Color name is too Long!").required("Color name is required"),
        code: yup.string().max(255, "Color code is too Long!").required("Color code is required"),
    })
    .required();


export type ProductColorFormValuesType = yup.InferType<
    typeof productColorFormSchema
>;