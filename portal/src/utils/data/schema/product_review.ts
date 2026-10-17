import * as yup from "yup";

export const productReviewFormSchema = yup
    .object()
    .shape({
        rating: yup.number().min(1, "Rating must be at least 1").max(5, "Rating must be at most 5").required("Rating is required"),
        comment: yup.string().max(500, "Comment is too Long!").required("Comment is required"),
    })
    .required();


export type ProductReviewFormValuesType = yup.InferType<
    typeof productReviewFormSchema
>;