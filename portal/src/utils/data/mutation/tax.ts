import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { TaxFormValuesType } from "../schema/tax";
import { createTaxHandler, deleteTaxHandler, toggleTaxStatusHandler, updateTaxHandler } from "../dal/tax";
import type { PaginationType, TaxType } from "@/utils/types";
import { TaxQueryKey, TaxesQueryKey } from "../query/tax";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";

export const useTaxCreateMutation = () => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: TaxFormValuesType) => {
            return await createTaxHandler(val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Tax created successfully");
            // context.client.invalidateQueries({ queryKey: TaxesQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(TaxesQueryKey(params), (oldData: PaginationType<TaxType> | undefined) => {
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
                context.client.invalidateQueries({ queryKey: TaxesQueryKey(params) });
            }
        },
    });
};

export const useTaxUpdateMutation = (id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: TaxFormValuesType) => {
            return await updateTaxHandler(id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Tax updated successfully");
            context.client.setQueryData(TaxesQueryKey(params), (oldData: PaginationType<TaxType> | undefined) => {
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
            context.client.setQueryData(TaxQueryKey(id), data);
            context.client.setQueryData(TaxQueryKey(id, true), data);
        },
    });
};

export const useTaxToggleStatusMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await toggleTaxStatusHandler(id);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Tax state toggled successfully");
            context.client.setQueryData(TaxesQueryKey(params), (oldData: PaginationType<TaxType> | undefined) => {
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
            context.client.setQueryData(TaxQueryKey(id), data);
            context.client.setQueryData(TaxQueryKey(id, true), data);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};


export const useTaxDeleteMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteTaxHandler(id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Tax deleted successfully");
            context.client.invalidateQueries({ queryKey: TaxesQueryKey(params) });
            context.client.setQueryData(TaxQueryKey(id), undefined);
            context.client.setQueryData(TaxQueryKey(id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};