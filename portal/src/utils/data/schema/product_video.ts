import * as yup from "yup";

export const productVideoFormSchema = yup
    .object()
    .shape({
        video: yup.string().url("Video URL is invalid").max(255, "Video URL is too Long!").required("Video URL is required"),
    })
    .required();


export type ProductVideoFormValuesType = yup.InferType<
    typeof productVideoFormSchema
>;