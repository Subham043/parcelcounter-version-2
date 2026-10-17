import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { ProductColorFormValuesType } from "../schema/product_color";
import { createProductColorHandler, deleteProductColorHandler, updateProductColorHandler } from "../dal/product_color";
import type { PaginationType, ProductColorType } from "@/utils/types";
import { ProductColorQueryKey, ProductColorsQueryKey } from "../query/product_color";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";

export const useProductColorCreateMutation = (product_id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: ProductColorFormValuesType) => {
            return await createProductColorHandler(product_id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Product color created successfully");
            // context.client.invalidateQueries({ queryKey: ProductColorsQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(ProductColorsQueryKey(product_id, params), (oldData: PaginationType<ProductColorType> | undefined) => {
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
                context.client.invalidateQueries({ queryKey: ProductColorsQueryKey(product_id, params) });
            }
        },
    });
};

export const useProductColorUpdateMutation = (product_id: number, id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: ProductColorFormValuesType) => {
            return await updateProductColorHandler(product_id, id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Product color updated successfully");
            context.client.setQueryData(ProductColorsQueryKey(product_id, params), (oldData: PaginationType<ProductColorType> | undefined) => {
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
            context.client.setQueryData(ProductColorQueryKey(product_id, id), data);
            context.client.setQueryData(ProductColorQueryKey(product_id, id, true), data);
        },
    });
};


export const useProductColorDeleteMutation = (product_id: number, id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteProductColorHandler(product_id, id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Product color deleted successfully");
            context.client.invalidateQueries({ queryKey: ProductColorsQueryKey(product_id, params) });
            context.client.setQueryData(ProductColorQueryKey(product_id, id), undefined);
            context.client.setQueryData(ProductColorQueryKey(product_id, id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};