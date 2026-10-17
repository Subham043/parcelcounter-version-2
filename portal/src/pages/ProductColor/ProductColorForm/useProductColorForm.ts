// hooks/useProductColorForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { productColorFormSchema, type ProductColorFormValuesType } from "@/utils/data/schema/product_color";
import { useProductColorModalStore } from "../store/product-color-modal.store";
import { useProductColorCreateMutation, useProductColorUpdateMutation } from "@/utils/data/mutation/product_color";
import { useProductColorQuery } from "@/utils/data/query/product_color";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: ProductColorFormValuesType = {
    name: "",
    code: "#000000",
}

export function useProductColorForm({ product_id }: { product_id: number }) {

    const modal = useProductColorModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useProductColorQuery(
        product_id,
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createProductColorMutation = useProductColorCreateMutation(product_id);
    const updateProductColorMutation = useProductColorUpdateMutation(product_id, modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(productColorFormSchema) as Resolver<ProductColorFormValuesType>,
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
                name: data?.name || "",
                code: data?.code || "#000000",
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useProductColorModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateProductColorMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ProductColorFormValuesType>);
                        },
                    });
                } else {
                    await createProductColorMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ProductColorFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createProductColorMutation.mutateAsync, updateProductColorMutation.mutateAsync, handleClose],
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
