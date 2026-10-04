import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { LegalContentFormValuesType } from "../schema/legal_content";
import { createLegalContentHandler, deleteLegalContentHandler, exportLegalContentsHandler, toggleLegalContentStatusHandler, updateLegalContentHandler } from "../dal/legal_content";
import type { PaginationType, LegalContentType } from "@/utils/types";
import { LegalContentQueryKey, LegalContentsQueryKey } from "../query/legal_content";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";
import { downloadExcel } from "@/utils/helper";

export const useLegalContentCreateMutation = () => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: LegalContentFormValuesType) => {
            return await createLegalContentHandler(val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Legal content created successfully");
            // context.client.invalidateQueries({ queryKey: LegalContentsQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(LegalContentsQueryKey(params), (oldData: PaginationType<LegalContentType> | undefined) => {
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
                context.client.invalidateQueries({ queryKey: LegalContentsQueryKey(params) });
            }
        },
    });
};

export const useLegalContentUpdateMutation = (id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: LegalContentFormValuesType) => {
            return await updateLegalContentHandler(id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Legal content updated successfully");
            context.client.setQueryData(LegalContentsQueryKey(params), (oldData: PaginationType<LegalContentType> | undefined) => {
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
            context.client.setQueryData(LegalContentQueryKey(id), data);
            context.client.setQueryData(LegalContentQueryKey(id, true), data);
        },
    });
};

export const useLegalContentToggleStatusMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await toggleLegalContentStatusHandler(id);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Legal content state toggled successfully");
            context.client.setQueryData(LegalContentsQueryKey(params), (oldData: PaginationType<LegalContentType> | undefined) => {
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
            context.client.setQueryData(LegalContentQueryKey(id), data);
            context.client.setQueryData(LegalContentQueryKey(id, true), data);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};


export const useLegalContentDeleteMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteLegalContentHandler(id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Legal content deleted successfully");
            context.client.invalidateQueries({ queryKey: LegalContentsQueryKey(params) });
            context.client.setQueryData(LegalContentQueryKey(id), undefined);
            context.client.setQueryData(LegalContentQueryKey(id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};

export const useLegalContentExportMutation = () => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await exportLegalContentsHandler(params);
        },
        onSuccess: (data) => {
            toastSuccess("Legal content exported successfully");
            downloadExcel(data, `legal_content_${new Date().toISOString().slice(0, 10)}.xlsx`);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};