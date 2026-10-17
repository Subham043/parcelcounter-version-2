// hooks/useProductImageForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { productImageFormSchema, type ProductImageFormValuesType } from "@/utils/data/schema/product_image";
import { useProductImageModalStore } from "../store/product-image-modal.store";
import { useProductImageCreateMutation, useProductImageUpdateMutation } from "@/utils/data/mutation/product_image";
import { useProductImageQuery } from "@/utils/data/query/product_image";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: ProductImageFormValuesType = {
    image_alt: undefined,
    image_title: undefined,
    image: undefined,
    is_create: true
}

export function useProductImageForm({ product_id }: { product_id: number }) {

    const modal = useProductImageModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useProductImageQuery(
        product_id,
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createProductImageMutation = useProductImageCreateMutation(product_id);
    const updateProductImageMutation = useProductImageUpdateMutation(product_id, modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(productImageFormSchema) as Resolver<ProductImageFormValuesType>,
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
                image_alt: data.image_alt || undefined,
                image_title: data.image_title || undefined,
                image: undefined,
                is_create: false,
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useProductImageModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateProductImageMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ProductImageFormValuesType>);
                        },
                    });
                } else {
                    await createProductImageMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ProductImageFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createProductImageMutation.mutateAsync, updateProductImageMutation.mutateAsync, handleClose],
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
