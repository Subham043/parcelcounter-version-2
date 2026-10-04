import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { CategoryFormValuesType } from "../schema/category";
import { createCategoryHandler, deleteCategoryHandler, exportCategoriesHandler, toggleCategoryStatusHandler, updateCategoryHandler } from "../dal/category";
import type { PaginationType, CategoryType } from "@/utils/types";
import { CategoryQueryKey, CategoriesQueryKey } from "../query/category";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";
import { downloadExcel } from "@/utils/helper";

export const useCategoryCreateMutation = () => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: CategoryFormValuesType) => {
            return await createCategoryHandler(val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Category created successfully");
            // context.client.invalidateQueries({ queryKey: CategoriesQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(CategoriesQueryKey(params), (oldData: PaginationType<CategoryType> | undefined) => {
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
                context.client.invalidateQueries({ queryKey: CategoriesQueryKey(params) });
            }
        },
    });
};

export const useCategoryUpdateMutation = (id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: CategoryFormValuesType) => {
            return await updateCategoryHandler(id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Category updated successfully");
            context.client.setQueryData(CategoriesQueryKey(params), (oldData: PaginationType<CategoryType> | undefined) => {
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
            context.client.setQueryData(CategoryQueryKey(id), data);
            context.client.setQueryData(CategoryQueryKey(id, true), data);
        },
    });
};

export const useCategoryToggleStatusMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await toggleCategoryStatusHandler(id);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Category state toggled successfully");
            context.client.setQueryData(CategoriesQueryKey(params), (oldData: PaginationType<CategoryType> | undefined) => {
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
            context.client.setQueryData(CategoryQueryKey(id), data);
            context.client.setQueryData(CategoryQueryKey(id, true), data);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};


export const useCategoryDeleteMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteCategoryHandler(id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Category deleted successfully");
            context.client.invalidateQueries({ queryKey: CategoriesQueryKey(params) });
            context.client.setQueryData(CategoryQueryKey(id), undefined);
            context.client.setQueryData(CategoryQueryKey(id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};

export const useCategoryExportMutation = () => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await exportCategoriesHandler(params);
        },
        onSuccess: (data) => {
            toastSuccess("Category exported successfully");
            downloadExcel(data, `category_${new Date().toISOString().slice(0, 10)}.xlsx`);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};