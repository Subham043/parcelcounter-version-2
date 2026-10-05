import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { SubCategoryFormValuesType } from "../schema/sub_category";
import { createSubCategoryHandler, deleteSubCategoryHandler, exportSubCategoriesHandler, toggleSubCategoryStatusHandler, updateSubCategoryHandler } from "../dal/sub_category";
import type { PaginationType, SubCategoryType } from "@/utils/types";
import { SubCategoryQueryKey, SubCategoriesQueryKey } from "../query/sub_category";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";
import { downloadExcel } from "@/utils/helper";

export const useSubCategoryCreateMutation = () => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: SubCategoryFormValuesType) => {
            return await createSubCategoryHandler(val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Sub-Category created successfully");
            // context.client.invalidateQueries({ queryKey: SubCategoriesQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(SubCategoriesQueryKey(params, true, false), (oldData: PaginationType<SubCategoryType> | undefined) => {
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
                context.client.invalidateQueries({ queryKey: SubCategoriesQueryKey(params, true, false) });
            }
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
            context.client.setQueryData(SubCategoriesQueryKey(params, true, false), (oldData: PaginationType<SubCategoryType> | undefined) => {
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
            context.client.setQueryData(SubCategoryQueryKey(id, true), data);
            context.client.setQueryData(SubCategoryQueryKey(id, true, true), data);
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
            context.client.setQueryData(SubCategoriesQueryKey(params, true, false), (oldData: PaginationType<SubCategoryType> | undefined) => {
                if (!oldData) return oldData;
                const oldUserDataIndex = oldData.data.findIndex((user) => user.id === id);
                if (oldUserDataIndex !== -1) {
                    const newData = [...oldData.data];
                    newData[oldUserDataIndex] = {
                        ...newData[oldUserDataIndex],
                        is_active: data.is_active
                    }
                    return {
                        ...oldData,
                        data: newData,
                    };
                }
                return oldData;
            });
            context.client.setQueryData(SubCategoryQueryKey(id, true), data);
            context.client.setQueryData(SubCategoryQueryKey(id, true, true), data);
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
            context.client.invalidateQueries({ queryKey: SubCategoriesQueryKey(params, true, false) });
            context.client.setQueryData(SubCategoryQueryKey(id, true), undefined);
            context.client.setQueryData(SubCategoryQueryKey(id, true, true), undefined);
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