import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { ProductPriceFormValuesType } from "../schema/product_price";
import { createProductPriceHandler, deleteProductPriceHandler, updateProductPriceHandler } from "../dal/product_price";
import type { PaginationType, ProductPriceType } from "@/utils/types";
import { ProductPriceQueryKey, ProductPricesQueryKey } from "../query/product_price";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";

export const useProductPriceCreateMutation = (product_id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: ProductPriceFormValuesType) => {
            return await createProductPriceHandler(product_id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Product price created successfully");
            // context.client.invalidateQueries({ queryKey: ProductPricesQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(ProductPricesQueryKey(product_id, params), (oldData: PaginationType<ProductPriceType> | undefined) => {
                    if (!oldData) return oldData;
                    if (oldData.data.length < total) {
                        return {
                            ...oldData,
                            data: [data, ...oldData.data],
                            meta: {
                                ...oldData.meta,
                                total: oldData.meta.total + 1,
                            },
                        };
                    } else {
                        const newData = [...oldData.data];
                        newData.splice(total - 1, 0, data);
                        return {
                            ...oldData,
                            data: [data, ...newData],
                            meta: {
                                ...oldData.meta,
                                total: oldData.meta.total + 1,
                            },
                        };
                    }
                });
            } else {
                context.client.invalidateQueries({ queryKey: ProductPricesQueryKey(product_id, params) });
            }
        },
    });
};

export const useProductPriceUpdateMutation = (product_id: number, id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: ProductPriceFormValuesType) => {
            return await updateProductPriceHandler(product_id, id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Product price updated successfully");
            context.client.setQueryData(ProductPricesQueryKey(product_id, params), (oldData: PaginationType<ProductPriceType> | undefined) => {
                if (!oldData) return oldData;
                const oldUserDataIndex = oldData.data.findIndex((user) => user.id === id);
                if (oldUserDataIndex !== -1) {
                    const newData = [...oldData.data];
                    newData[oldUserDataIndex] = data;
                    return {
                        ...oldData,
                        data: newData,
                    };
                }
                return oldData;
            });
            context.client.setQueryData(ProductPriceQueryKey(product_id, id), data);
            context.client.setQueryData(ProductPriceQueryKey(product_id, id, true), data);
        },
    });
};


export const useProductPriceDeleteMutation = (product_id: number, id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteProductPriceHandler(product_id, id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Product price deleted successfully");
            context.client.invalidateQueries({ queryKey: ProductPricesQueryKey(product_id, params) });
            context.client.setQueryData(ProductPriceQueryKey(product_id, id), undefined);
            context.client.setQueryData(ProductPriceQueryKey(product_id, id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};