import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { FeatureFormValuesType } from "../schema/feature";
import { createFeatureHandler, deleteFeatureHandler, toggleFeatureStatusHandler, updateFeatureHandler } from "../dal/feature";
import type { PaginationType, FeatureType } from "@/utils/types";
import { FeatureQueryKey, FeaturesQueryKey } from "../query/feature";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";

export const useFeatureCreateMutation = () => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: FeatureFormValuesType) => {
            return await createFeatureHandler(val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Feature created successfully");
            // context.client.invalidateQueries({ queryKey: FeaturesQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(FeaturesQueryKey(params), (oldData: PaginationType<FeatureType> | undefined) => {
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
                context.client.invalidateQueries({ queryKey: FeaturesQueryKey(params) });
            }
        },
    });
};

export const useFeatureUpdateMutation = (id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: FeatureFormValuesType) => {
            return await updateFeatureHandler(id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Feature updated successfully");
            context.client.setQueryData(FeaturesQueryKey(params), (oldData: PaginationType<FeatureType> | undefined) => {
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
            context.client.setQueryData(FeatureQueryKey(id), data);
            context.client.setQueryData(FeatureQueryKey(id, true), data);
        },
    });
};

export const useFeatureToggleStatusMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await toggleFeatureStatusHandler(id);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Feature state toggled successfully");
            context.client.setQueryData(FeaturesQueryKey(params), (oldData: PaginationType<FeatureType> | undefined) => {
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
            context.client.setQueryData(FeatureQueryKey(id), data);
            context.client.setQueryData(FeatureQueryKey(id, true), data);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};


export const useFeatureDeleteMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteFeatureHandler(id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Feature deleted successfully");
            context.client.invalidateQueries({ queryKey: FeaturesQueryKey(params) });
            context.client.setQueryData(FeatureQueryKey(id), undefined);
            context.client.setQueryData(FeatureQueryKey(id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};