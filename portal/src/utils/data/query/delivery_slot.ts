import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, DeliverySlotType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getDeliverySlotHandler, getDeliverySlotsHandler } from "../dal/delivery_slot";
import { useSearchParams } from "react-router";


export const DeliverySlotQueryKey = (id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["delivery-slot", id, "edit"]
    }
    return ["delivery-slot", id, "view"]
};

export const DeliverySlotsQueryKey = (params: URLSearchParams) => {
    return ["delivery-slots", params.toString()]
};

export const DeliverySlotQueryFn = async ({ id, signal }: { id: number, signal?: AbortSignal }) => {
    return await getDeliverySlotHandler(id, signal);
}

export const DeliverySlotsQueryFn = async ({ params, signal }: { params: URLSearchParams, signal?: AbortSignal }) => {
    return await getDeliverySlotsHandler(params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useDeliverySlotQuery: (id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    DeliverySlotType | undefined,
    unknown
> = (id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: DeliverySlotQueryKey(id, isEdit),
        queryFn: ({ signal }) => DeliverySlotQueryFn({ id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useDeliverySlotsQuery: () => UseQueryResult<
    PaginationType<DeliverySlotType> | undefined,
    unknown
> = () => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: DeliverySlotsQueryKey(params),
        queryFn: ({ signal }) => DeliverySlotsQueryFn({ params, signal }),
        enabled: authToken !== null,
    });
};