import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { SubCategoryFormValuesType } from "../schema/sub_category";
import { createSubCategoryHandler, deleteSubCategoryHandler, exportSubCategoriesHandler, toggleSubCategoryStatusHandler, updateSubCategoryHandler } from "../dal/sub_category";
import { SubCategoryQueryKey, SubCategoriesQueryKey } from "../query/sub_category";
import { useSearchParams } from "react-router";
import { downloadExcel } from "@/utils/helper";

export const useSubCategoryCreateMutation = () => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: SubCategoryFormValuesType) => {
            return await createSubCategoryHandler(val);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Sub-Category created successfully");
            context.client.invalidateQueries({ queryKey: SubCategoriesQueryKey(params, { includeCategory: true }) });
        },
    });
};

export const useSubCategoryUpdateMutation = (id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: SubCategoryFormValuesType) => {
            return await updateSubCategoryHandler(id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Sub-Category updated successfully");
            context.client.invalidateQueries({ queryKey: SubCategoriesQueryKey(params, { includeCategory: true }) });
            context.client.setQueryData(SubCategoryQueryKey(id, { includeCategory: true }), data);
            context.client.setQueryData(SubCategoryQueryKey(id, { includeCategory: true }, true), data);
        },
    });
};

export const useSubCategoryToggleStatusMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await toggleSubCategoryStatusHandler(id);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Sub-Category state toggled successfully");
            context.client.invalidateQueries({ queryKey: SubCategoriesQueryKey(params, { includeCategory: true }) });
            context.client.setQueryData(SubCategoryQueryKey(id, { includeCategory: true }), data);
            context.client.setQueryData(SubCategoryQueryKey(id, { includeCategory: true }, true), data);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};


export const useSubCategoryDeleteMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteSubCategoryHandler(id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Sub-Category deleted successfully");
            context.client.invalidateQueries({ queryKey: SubCategoriesQueryKey(params, { includeCategory: true }) });
            context.client.setQueryData(SubCategoryQueryKey(id, { includeCategory: true }), undefined);
            context.client.setQueryData(SubCategoryQueryKey(id, { includeCategory: true }, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};

export const useSubCategoryExportMutation = () => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await exportSubCategoriesHandler(params);
        },
        onSuccess: (data) => {
            toastSuccess("Sub-Category exported successfully");
            downloadExcel(data, `sub_category_${new Date().toISOString().slice(0, 10)}.xlsx`);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};