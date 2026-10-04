import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { ChargeFormValuesType } from "../schema/charge";
import { createChargeHandler, deleteChargeHandler, exportChargesHandler, toggleChargeStatusHandler, updateChargeHandler } from "../dal/charge";
import type { PaginationType, ChargeType } from "@/utils/types";
import { ChargeQueryKey, ChargesQueryKey } from "../query/charge";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";
import { downloadExcel } from "@/utils/helper";

export const useChargeCreateMutation = () => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: ChargeFormValuesType) => {
            return await createChargeHandler(val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Charge created successfully");
            // context.client.invalidateQueries({ queryKey: ChargesQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(ChargesQueryKey(params), (oldData: PaginationType<ChargeType> | undefined) => {
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
                context.client.invalidateQueries({ queryKey: ChargesQueryKey(params) });
            }
        },
    });
};

export const useChargeUpdateMutation = (id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: ChargeFormValuesType) => {
            return await updateChargeHandler(id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Charge updated successfully");
            context.client.setQueryData(ChargesQueryKey(params), (oldData: PaginationType<ChargeType> | undefined) => {
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
            context.client.setQueryData(ChargeQueryKey(id), data);
            context.client.setQueryData(ChargeQueryKey(id, true), data);
        },
    });
};

export const useChargeToggleStatusMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await toggleChargeStatusHandler(id);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Charge state toggled successfully");
            context.client.setQueryData(ChargesQueryKey(params), (oldData: PaginationType<ChargeType> | undefined) => {
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
            context.client.setQueryData(ChargeQueryKey(id), data);
            context.client.setQueryData(ChargeQueryKey(id, true), data);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};


export const useChargeDeleteMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteChargeHandler(id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Charge deleted successfully");
            context.client.invalidateQueries({ queryKey: ChargesQueryKey(params) });
            context.client.setQueryData(ChargeQueryKey(id), undefined);
            context.client.setQueryData(ChargeQueryKey(id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};

export const useChargeExportMutation = () => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await exportChargesHandler(params);
        },
        onSuccess: (data) => {
            toastSuccess("Charges exported successfully");
            downloadExcel(data, `charges_${new Date().toISOString().slice(0, 10)}.xlsx`);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};