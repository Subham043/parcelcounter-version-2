import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { ProductFormValuesType } from "../schema/product";
import { createProductHandler, deleteProductHandler, exportProductsHandler, toggleProductStatusHandler, updateProductHandler } from "../dal/product";
import { ProductQueryKey, ProductsQueryKey } from "../query/product";
import { useSearchParams } from "react-router";
import { downloadExcel } from "@/utils/helper";

export const useProductCreateMutation = () => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: ProductFormValuesType) => {
            return await createProductHandler(val);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Product created successfully");
            context.client.invalidateQueries({ queryKey: ProductsQueryKey(params, { includeCategory: true, includeSubCategory: true }) });
        },
    });
};

export const useProductUpdateMutation = (id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: ProductFormValuesType) => {
            return await updateProductHandler(id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Product updated successfully");
            context.client.invalidateQueries({ queryKey: ProductsQueryKey(params, { includeCategory: true, includeSubCategory: true }) });
            context.client.setQueryData(ProductQueryKey(id), data);
            context.client.setQueryData(ProductQueryKey(id, undefined, true), data);
        },
    });
};

export const useProductToggleStatusMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await toggleProductStatusHandler(id);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Product state toggled successfully");
            context.client.invalidateQueries({ queryKey: ProductsQueryKey(params, { includeCategory: true, includeSubCategory: true }) });
            context.client.setQueryData(ProductQueryKey(id), data);
            context.client.setQueryData(ProductQueryKey(id, undefined, true), data);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};


export const useProductDeleteMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteProductHandler(id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Product deleted successfully");
            context.client.invalidateQueries({ queryKey: ProductsQueryKey(params, { includeCategory: true, includeSubCategory: true }) });
            context.client.setQueryData(ProductQueryKey(id), undefined);
            context.client.setQueryData(ProductQueryKey(id, undefined, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};

export const useProductExportMutation = () => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await exportProductsHandler(params);
        },
        onSuccess: (data) => {
            toastSuccess("Product exported successfully");
            downloadExcel(data, `product_${new Date().toISOString().slice(0, 10)}.xlsx`);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};