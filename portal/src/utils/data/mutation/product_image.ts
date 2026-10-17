import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { ProductImageFormValuesType } from "../schema/product_image";
import { createProductImageHandler, deleteProductImageHandler, updateProductImageHandler } from "../dal/product_image";
import type { PaginationType, ProductImageType } from "@/utils/types";
import { ProductImageQueryKey, ProductImagesQueryKey } from "../query/product_image";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";

export const useProductImageCreateMutation = (product_id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: ProductImageFormValuesType) => {
            return await createProductImageHandler(product_id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Product image created successfully");
            // context.client.invalidateQueries({ queryKey: ProductImagesQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(ProductImagesQueryKey(product_id, params), (oldData: PaginationType<ProductImageType> | undefined) => {
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
                context.client.invalidateQueries({ queryKey: ProductImagesQueryKey(product_id, params) });
            }
        },
    });
};

export const useProductImageUpdateMutation = (product_id: number, id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: ProductImageFormValuesType) => {
            return await updateProductImageHandler(product_id, id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Product image updated successfully");
            context.client.setQueryData(ProductImagesQueryKey(product_id, params), (oldData: PaginationType<ProductImageType> | undefined) => {
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
            context.client.setQueryData(ProductImageQueryKey(product_id, id), data);
            context.client.setQueryData(ProductImageQueryKey(product_id, id, true), data);
        },
    });
};


export const useProductImageDeleteMutation = (product_id: number, id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteProductImageHandler(product_id, id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Product image deleted successfully");
            context.client.invalidateQueries({ queryKey: ProductImagesQueryKey(product_id, params) });
            context.client.setQueryData(ProductImageQueryKey(product_id, id), undefined);
            context.client.setQueryData(ProductImageQueryKey(product_id, id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};