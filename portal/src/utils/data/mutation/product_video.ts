import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { ProductVideoFormValuesType } from "../schema/product_video";
import { createProductVideoHandler, deleteProductVideoHandler, updateProductVideoHandler } from "../dal/product_video";
import type { PaginationType, ProductVideoType } from "@/utils/types";
import { ProductVideoQueryKey, ProductVideosQueryKey } from "../query/product_video";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";

export const useProductVideoCreateMutation = (product_id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: ProductVideoFormValuesType) => {
            return await createProductVideoHandler(product_id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Product video created successfully");
            // context.client.invalidateQueries({ queryKey: ProductVideosQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(ProductVideosQueryKey(product_id, params), (oldData: PaginationType<ProductVideoType> | undefined) => {
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
                context.client.invalidateQueries({ queryKey: ProductVideosQueryKey(product_id, params) });
            }
        },
    });
};

export const useProductVideoUpdateMutation = (product_id: number, id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: ProductVideoFormValuesType) => {
            return await updateProductVideoHandler(product_id, id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Product video updated successfully");
            context.client.setQueryData(ProductVideosQueryKey(product_id, params), (oldData: PaginationType<ProductVideoType> | undefined) => {
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
            context.client.setQueryData(ProductVideoQueryKey(product_id, id), data);
            context.client.setQueryData(ProductVideoQueryKey(product_id, id, true), data);
        },
    });
};


export const useProductVideoDeleteMutation = (product_id: number, id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteProductVideoHandler(product_id, id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Product video deleted successfully");
            context.client.invalidateQueries({ queryKey: ProductVideosQueryKey(product_id, params) });
            context.client.setQueryData(ProductVideoQueryKey(product_id, id), undefined);
            context.client.setQueryData(ProductVideoQueryKey(product_id, id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};