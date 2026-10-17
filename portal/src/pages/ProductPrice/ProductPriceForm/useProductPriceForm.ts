// hooks/useProductPriceForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { productPriceFormSchema, type ProductPriceFormValuesType } from "@/utils/data/schema/product_price";
import { useProductPriceModalStore } from "../store/product-price-modal.store";
import { useProductPriceCreateMutation, useProductPriceUpdateMutation } from "@/utils/data/mutation/product_price";
import { useProductPriceQuery } from "@/utils/data/query/product_price";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: ProductPriceFormValuesType = {
    min_quantity: 1,
    price: 1,
}

export function useProductPriceForm({ product_id }: { product_id: number }) {

    const modal = useProductPriceModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useProductPriceQuery(
        product_id,
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createProductPriceMutation = useProductPriceCreateMutation(product_id);
    const updateProductPriceMutation = useProductPriceUpdateMutation(product_id, modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(productPriceFormSchema) as Resolver<ProductPriceFormValuesType>,
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
                min_quantity: data?.min_quantity || 1,
                price: data?.price || 1,
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useProductPriceModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateProductPriceMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ProductPriceFormValuesType>);
                        },
                    });
                } else {
                    await createProductPriceMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ProductPriceFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createProductPriceMutation.mutateAsync, updateProductPriceMutation.mutateAsync, handleClose],
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
