import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { CertificationFormValuesType } from "../schema/certification";
import { createCertificationHandler, deleteCertificationHandler, exportCertificationsHandler, toggleCertificationStatusHandler, updateCertificationHandler } from "../dal/certification";
import type { PaginationType, CertificationType } from "@/utils/types";
import { CertificationQueryKey, CertificationsQueryKey } from "../query/certification";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";
import { downloadExcel } from "@/utils/helper";

export const useCertificationCreateMutation = () => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: CertificationFormValuesType) => {
            return await createCertificationHandler(val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Certification created successfully");
            // context.client.invalidateQueries({ queryKey: CertificationsQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(CertificationsQueryKey(params), (oldData: PaginationType<CertificationType> | undefined) => {
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
                context.client.invalidateQueries({ queryKey: CertificationsQueryKey(params) });
            }
        },
    });
};

export const useCertificationUpdateMutation = (id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: CertificationFormValuesType) => {
            return await updateCertificationHandler(id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Certification updated successfully");
            context.client.setQueryData(CertificationsQueryKey(params), (oldData: PaginationType<CertificationType> | undefined) => {
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
            context.client.setQueryData(CertificationQueryKey(id), data);
            context.client.setQueryData(CertificationQueryKey(id, true), data);
        },
    });
};

export const useCertificationToggleStatusMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await toggleCertificationStatusHandler(id);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Certification state toggled successfully");
            context.client.setQueryData(CertificationsQueryKey(params), (oldData: PaginationType<CertificationType> | undefined) => {
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
            context.client.setQueryData(CertificationQueryKey(id), data);
            context.client.setQueryData(CertificationQueryKey(id, true), data);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};


export const useCertificationDeleteMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteCertificationHandler(id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Certification deleted successfully");
            context.client.invalidateQueries({ queryKey: CertificationsQueryKey(params) });
            context.client.setQueryData(CertificationQueryKey(id), undefined);
            context.client.setQueryData(CertificationQueryKey(id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};

export const useCertificationExportMutation = () => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await exportCertificationsHandler(params);
        },
        onSuccess: (data) => {
            toastSuccess("Certifications exported successfully");
            downloadExcel(data, `certifications_${new Date().toISOString().slice(0, 10)}.xlsx`);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};