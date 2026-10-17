import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { ProductStockFormValuesType } from "../schema/product_stock";
import { createProductStockHandler, deleteProductStockHandler, updateProductStockHandler } from "../dal/product_stock";
import type { PaginationType, ProductStockType } from "@/utils/types";
import { ProductStockQueryKey, ProductStocksQueryKey } from "../query/product_stock";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";

export const useProductStockCreateMutation = (product_id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: ProductStockFormValuesType) => {
            return await createProductStockHandler(product_id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Product stock created successfully");
            // context.client.invalidateQueries({ queryKey: ProductStocksQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(ProductStocksQueryKey(product_id, params), (oldData: PaginationType<ProductStockType> | undefined) => {
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
                context.client.invalidateQueries({ queryKey: ProductStocksQueryKey(product_id, params) });
            }
        },
    });
};

export const useProductStockUpdateMutation = (product_id: number, id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: ProductStockFormValuesType) => {
            return await updateProductStockHandler(product_id, id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Product stock updated successfully");
            context.client.setQueryData(ProductStocksQueryKey(product_id, params), (oldData: PaginationType<ProductStockType> | undefined) => {
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
            context.client.setQueryData(ProductStockQueryKey(product_id, id), data);
            context.client.setQueryData(ProductStockQueryKey(product_id, id, true), data);
        },
    });
};


export const useProductStockDeleteMutation = (product_id: number, id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteProductStockHandler(product_id, id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Product stock deleted successfully");
            context.client.invalidateQueries({ queryKey: ProductStocksQueryKey(product_id, params) });
            context.client.setQueryData(ProductStockQueryKey(product_id, id), undefined);
            context.client.setQueryData(ProductStockQueryKey(product_id, id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};