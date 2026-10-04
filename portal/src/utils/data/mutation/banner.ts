import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { BannerFormValuesType } from "../schema/banner";
import { createBannerHandler, deleteBannerHandler, exportBannersHandler, toggleBannerStatusHandler, updateBannerHandler } from "../dal/banner";
import type { PaginationType, BannerType } from "@/utils/types";
import { BannerQueryKey, BannersQueryKey } from "../query/banner";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";
import { downloadExcel } from "@/utils/helper";

export const useBannerCreateMutation = () => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: BannerFormValuesType) => {
            return await createBannerHandler(val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Banner created successfully");
            // context.client.invalidateQueries({ queryKey: BannersQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(BannersQueryKey(params), (oldData: PaginationType<BannerType> | undefined) => {
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
                context.client.invalidateQueries({ queryKey: BannersQueryKey(params) });
            }
        },
    });
};

export const useBannerUpdateMutation = (id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: BannerFormValuesType) => {
            return await updateBannerHandler(id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Banner updated successfully");
            context.client.setQueryData(BannersQueryKey(params), (oldData: PaginationType<BannerType> | undefined) => {
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
            context.client.setQueryData(BannerQueryKey(id), data);
            context.client.setQueryData(BannerQueryKey(id, true), data);
        },
    });
};

export const useBannerToggleStatusMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await toggleBannerStatusHandler(id);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Banner state toggled successfully");
            context.client.setQueryData(BannersQueryKey(params), (oldData: PaginationType<BannerType> | undefined) => {
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
            context.client.setQueryData(BannerQueryKey(id), data);
            context.client.setQueryData(BannerQueryKey(id, true), data);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};


export const useBannerDeleteMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteBannerHandler(id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Banner deleted successfully");
            context.client.invalidateQueries({ queryKey: BannersQueryKey(params) });
            context.client.setQueryData(BannerQueryKey(id), undefined);
            context.client.setQueryData(BannerQueryKey(id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};

export const useBannerExportMutation = () => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await exportBannersHandler(params);
        },
        onSuccess: (data) => {
            toastSuccess("Banners exported successfully");
            downloadExcel(data, `banners_${new Date().toISOString().slice(0, 10)}.xlsx`);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};