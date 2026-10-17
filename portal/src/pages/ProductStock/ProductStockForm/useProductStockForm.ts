// hooks/useProductStockForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { productStockFormSchema, type ProductStockFormValuesType } from "@/utils/data/schema/product_stock";
import { useProductStockModalStore } from "../store/product-stock-modal.store";
import { useProductStockCreateMutation, useProductStockUpdateMutation } from "@/utils/data/mutation/product_stock";
import { useProductStockQuery } from "@/utils/data/query/product_stock";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: ProductStockFormValuesType = {
    purchase_stock: 1,
    quantity: 1,
    purchased_at: new Date(),
}

export function useProductStockForm({ product_id }: { product_id: number }) {

    const modal = useProductStockModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useProductStockQuery(
        product_id,
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createProductStockMutation = useProductStockCreateMutation(product_id);
    const updateProductStockMutation = useProductStockUpdateMutation(product_id, modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(productStockFormSchema) as Resolver<ProductStockFormValuesType>,
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
                purchase_stock: data?.purchase_stock || 1,
                quantity: data?.quantity || 1,
                purchased_at: new Date(data?.purchased_at) || new Date(),
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useProductStockModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateProductStockMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ProductStockFormValuesType>);
                        },
                    });
                } else {
                    await createProductStockMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ProductStockFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createProductStockMutation.mutateAsync, updateProductStockMutation.mutateAsync, handleClose],
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
