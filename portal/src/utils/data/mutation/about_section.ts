import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { AboutSectionFormValuesType } from "../schema/about_section";
import { createAboutSectionHandler, deleteAboutSectionHandler, exportAboutSectionsHandler, toggleAboutSectionStatusHandler, updateAboutSectionHandler } from "../dal/about_section";
import type { PaginationType, AboutSectionType } from "@/utils/types";
import { AboutSectionQueryKey, AboutSectionsQueryKey } from "../query/about_section";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";
import { downloadExcel } from "@/utils/helper";

export const useAboutSectionCreateMutation = () => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: AboutSectionFormValuesType) => {
            return await createAboutSectionHandler(val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("About section created successfully");
            // context.client.invalidateQueries({ queryKey: AboutSectionsQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(AboutSectionsQueryKey(params), (oldData: PaginationType<AboutSectionType> | undefined) => {
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
                context.client.invalidateQueries({ queryKey: AboutSectionsQueryKey(params) });
            }
        },
    });
};

export const useAboutSectionUpdateMutation = (id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: AboutSectionFormValuesType) => {
            return await updateAboutSectionHandler(id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("About section updated successfully");
            context.client.setQueryData(AboutSectionsQueryKey(params), (oldData: PaginationType<AboutSectionType> | undefined) => {
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
            context.client.setQueryData(AboutSectionQueryKey(id), data);
            context.client.setQueryData(AboutSectionQueryKey(id, true), data);
        },
    });
};

export const useAboutSectionToggleStatusMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await toggleAboutSectionStatusHandler(id);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("About section state toggled successfully");
            context.client.setQueryData(AboutSectionsQueryKey(params), (oldData: PaginationType<AboutSectionType> | undefined) => {
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
            context.client.setQueryData(AboutSectionQueryKey(id), data);
            context.client.setQueryData(AboutSectionQueryKey(id, true), data);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};


export const useAboutSectionDeleteMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteAboutSectionHandler(id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("About section deleted successfully");
            context.client.invalidateQueries({ queryKey: AboutSectionsQueryKey(params) });
            context.client.setQueryData(AboutSectionQueryKey(id), undefined);
            context.client.setQueryData(AboutSectionQueryKey(id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};

export const useAboutSectionExportMutation = () => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await exportAboutSectionsHandler(params);
        },
        onSuccess: (data) => {
            toastSuccess("About section exported successfully");
            downloadExcel(data, `about_section_${new Date().toISOString().slice(0, 10)}.xlsx`);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};