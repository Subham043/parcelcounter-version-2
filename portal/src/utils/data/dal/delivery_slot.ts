import type { GenericAbortSignal } from "axios";
import type { DeliverySlotFormValuesType } from "../schema/delivery_slot";
import axios from "@/utils/axios";
import type { DeliverySlotType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";


export const createDeliverySlotHandler = async (val: DeliverySlotFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: DeliverySlotType }>(api_routes.delivery_slot.create, { ...val, is_active: val.is_active ? 1 : 0, is_cod_allowed: val.is_cod_allowed ? 1 : 0 }, { signal });
    return response.data.data;
}


export const updateDeliverySlotHandler = async (id: number, val: DeliverySlotFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: DeliverySlotType }>(api_routes.delivery_slot.update + `/${id}`, { ...val, is_active: val.is_active ? 1 : 0, is_cod_allowed: val.is_cod_allowed ? 1 : 0 }, { signal });
    return response.data.data;
}


export const deleteDeliverySlotHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: DeliverySlotType }>(api_routes.delivery_slot.delete + `/${id}`, { signal });
    return response.data.data;
}


export const toggleDeliverySlotStatusHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: DeliverySlotType }>(api_routes.delivery_slot.toggle_status + `/${id}`, { signal });
    return response.data.data;
}


export const getDeliverySlotHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: DeliverySlotType }>(api_routes.delivery_slot.view + `/${id}`, { signal });
    return response.data.data;
}

export const getDeliverySlotsHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<DeliverySlotType>>(api_routes.delivery_slot.paginate, { params, signal });
    return response.data;
}