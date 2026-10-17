import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { ProductReviewFormValuesType } from "../schema/product_review";
import { createProductReviewHandler, deleteProductReviewHandler, toggleProductReviewStatusHandler, updateProductReviewHandler } from "../dal/product_review";
import type { PaginationType, ProductReviewType } from "@/utils/types";
import { ProductReviewQueryKey, ProductReviewsQueryKey } from "../query/product_review";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";

export const useProductReviewCreateMutation = (product_id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: ProductReviewFormValuesType) => {
            return await createProductReviewHandler(product_id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Product review created successfully");
            // context.client.invalidateQueries({ queryKey: ProductReviewsQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(ProductReviewsQueryKey(product_id, params), (oldData: PaginationType<ProductReviewType> | undefined) => {
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
                context.client.invalidateQueries({ queryKey: ProductReviewsQueryKey(product_id, params) });
            }
        },
    });
};

export const useProductReviewUpdateMutation = (product_id: number, id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: ProductReviewFormValuesType) => {
            return await updateProductReviewHandler(product_id, id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Product review updated successfully");
            context.client.setQueryData(ProductReviewsQueryKey(product_id, params), (oldData: PaginationType<ProductReviewType> | undefined) => {
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
            context.client.setQueryData(ProductReviewQueryKey(product_id, id), data);
            context.client.setQueryData(ProductReviewQueryKey(product_id, id, true), data);
        },
    });
};


export const useProductReviewToggleStatusMutation = (product_id: number, id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await toggleProductReviewStatusHandler(product_id, id);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Product review state toggled successfully");
            context.client.setQueryData(ProductReviewsQueryKey(product_id, params), (oldData: PaginationType<ProductReviewType> | undefined) => {
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
            context.client.setQueryData(ProductReviewQueryKey(product_id, id), data);
            context.client.setQueryData(ProductReviewQueryKey(product_id, id, true), data);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};

export const useProductReviewDeleteMutation = (product_id: number, id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteProductReviewHandler(product_id, id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Product review deleted successfully");
            context.client.invalidateQueries({ queryKey: ProductReviewsQueryKey(product_id, params) });
            context.client.setQueryData(ProductReviewQueryKey(product_id, id), undefined);
            context.client.setQueryData(ProductReviewQueryKey(product_id, id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};