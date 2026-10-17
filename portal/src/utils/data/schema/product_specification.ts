import * as yup from "yup";

export const productSpecificationFormSchema = yup
    .object()
    .shape({
        title: yup.string().max(255, "Specification title is too Long!").required("Specification title is required"),
        description: yup.string().max(500, "Specification description is too Long!").required("Specification description is required"),
    })
    .required();


export type ProductSpecificationFormValuesType = yup.InferType<
    typeof productSpecificationFormSchema
>;