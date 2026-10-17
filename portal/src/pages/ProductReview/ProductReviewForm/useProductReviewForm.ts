// hooks/useProductReviewForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { productReviewFormSchema, type ProductReviewFormValuesType } from "@/utils/data/schema/product_review";
import { useProductReviewModalStore } from "../store/product-review-modal.store";
import { useProductReviewCreateMutation, useProductReviewUpdateMutation } from "@/utils/data/mutation/product_review";
import { useProductReviewQuery } from "@/utils/data/query/product_review";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: ProductReviewFormValuesType = {
    rating: 5,
    comment: "",
}

export function useProductReviewForm({ product_id }: { product_id: number }) {

    const modal = useProductReviewModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useProductReviewQuery(
        product_id,
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createProductReviewMutation = useProductReviewCreateMutation(product_id);
    const updateProductReviewMutation = useProductReviewUpdateMutation(product_id, modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(productReviewFormSchema) as Resolver<ProductReviewFormValuesType>,
        defaultValues: FORM_DEFAULT_VALUES,
    });

    useEffect(() => {
        if (!modal.show) return;

        if (modal.type === "create") {
            form.reset(FORM_DEFAULT_VALUES);
            return;
        }

        if (modal.type === "update" && data) {
            form.reset({
                rating: data?.rating || 5,
                comment: data?.comment || "",
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useProductReviewModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateProductReviewMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ProductReviewFormValuesType>);
                        },
                    });
                } else {
                    await createProductReviewMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ProductReviewFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createProductReviewMutation.mutateAsync, updateProductReviewMutation.mutateAsync, handleClose],
    );

    return {
        form,
        modal,
        data,
        isLoading: isLoading || isFetching || isRefetching,
        onSubmit,
        handleClose,
    };
}
