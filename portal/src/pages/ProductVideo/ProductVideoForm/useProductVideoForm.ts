// hooks/useProductVideoForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { productVideoFormSchema, type ProductVideoFormValuesType } from "@/utils/data/schema/product_video";
import { useProductVideoModalStore } from "../store/product-video-modal.store";
import { useProductVideoCreateMutation, useProductVideoUpdateMutation } from "@/utils/data/mutation/product_video";
import { useProductVideoQuery } from "@/utils/data/query/product_video";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: ProductVideoFormValuesType = {
    video: "",
}

export function useProductVideoForm({ product_id }: { product_id: number }) {

    const modal = useProductVideoModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useProductVideoQuery(
        product_id,
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createProductVideoMutation = useProductVideoCreateMutation(product_id);
    const updateProductVideoMutation = useProductVideoUpdateMutation(product_id, modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(productVideoFormSchema) as Resolver<ProductVideoFormValuesType>,
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
                video: data?.video || "",
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useProductVideoModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateProductVideoMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ProductVideoFormValuesType>);
                        },
                    });
                } else {
                    await createProductVideoMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ProductVideoFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createProductVideoMutation.mutateAsync, updateProductVideoMutation.mutateAsync, handleClose],
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
