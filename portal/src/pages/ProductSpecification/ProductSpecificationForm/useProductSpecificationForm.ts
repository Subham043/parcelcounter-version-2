// hooks/useProductSpecificationForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { productSpecificationFormSchema, type ProductSpecificationFormValuesType } from "@/utils/data/schema/product_specification";
import { useProductSpecificationModalStore } from "../store/product-specification-modal.store";
import { useProductSpecificationCreateMutation, useProductSpecificationUpdateMutation } from "@/utils/data/mutation/product_specification";
import { useProductSpecificationQuery } from "@/utils/data/query/product_specification";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: ProductSpecificationFormValuesType = {
    title: "",
    description: "",
}

export function useProductSpecificationForm({ product_id }: { product_id: number }) {

    const modal = useProductSpecificationModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useProductSpecificationQuery(
        product_id,
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createProductSpecificationMutation = useProductSpecificationCreateMutation(product_id);
    const updateProductSpecificationMutation = useProductSpecificationUpdateMutation(product_id, modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(productSpecificationFormSchema) as Resolver<ProductSpecificationFormValuesType>,
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
                title: data?.title || "",
                description: data?.description || "",
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useProductSpecificationModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateProductSpecificationMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ProductSpecificationFormValuesType>);
                        },
                    });
                } else {
                    await createProductSpecificationMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ProductSpecificationFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createProductSpecificationMutation.mutateAsync, updateProductSpecificationMutation.mutateAsync, handleClose],
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
