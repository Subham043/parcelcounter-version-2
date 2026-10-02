import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { DeliverySlotFormValuesType } from "../schema/delivery_slot";
import { createDeliverySlotHandler, deleteDeliverySlotHandler, toggleDeliverySlotStatusHandler, updateDeliverySlotHandler } from "../dal/delivery_slot";
import type { PaginationType, DeliverySlotType } from "@/utils/types";
import { DeliverySlotQueryKey, DeliverySlotsQueryKey } from "../query/delivery_slot";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";

export const useDeliverySlotCreateMutation = () => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: DeliverySlotFormValuesType) => {
            return await createDeliverySlotHandler(val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Delivery slot created successfully");
            // context.client.invalidateQueries({ queryKey: DeliverySlotsQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(DeliverySlotsQueryKey(params), (oldData: PaginationType<DeliverySlotType> | undefined) => {
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
                context.client.invalidateQueries({ queryKey: DeliverySlotsQueryKey(params) });
            }
        },
    });
};

export const useDeliverySlotUpdateMutation = (id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: DeliverySlotFormValuesType) => {
            return await updateDeliverySlotHandler(id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Delivery slot updated successfully");
            context.client.setQueryData(DeliverySlotsQueryKey(params), (oldData: PaginationType<DeliverySlotType> | undefined) => {
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
            context.client.setQueryData(DeliverySlotQueryKey(id), data);
            context.client.setQueryData(DeliverySlotQueryKey(id, true), data);
        },
    });
};

export const useDeliverySlotToggleStatusMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await toggleDeliverySlotStatusHandler(id);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Delivery slot state toggled successfully");
            context.client.setQueryData(DeliverySlotsQueryKey(params), (oldData: PaginationType<DeliverySlotType> | undefined) => {
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
            context.client.setQueryData(DeliverySlotQueryKey(id), data);
            context.client.setQueryData(DeliverySlotQueryKey(id, true), data);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};


export const useDeliverySlotDeleteMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteDeliverySlotHandler(id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Delivery slot deleted successfully");
            context.client.invalidateQueries({ queryKey: DeliverySlotsQueryKey(params) });
            context.client.setQueryData(DeliverySlotQueryKey(id), undefined);
            context.client.setQueryData(DeliverySlotQueryKey(id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};