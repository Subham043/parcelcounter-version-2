import type { GenericAbortSignal } from "axios";
import type { ChargeFormValuesType } from "../schema/charge";
import axios from "@/utils/axios";
import type { ChargeType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";


export const createChargeHandler = async (val: ChargeFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ChargeType }>(api_routes.charge.create, { ...val, is_active: val.is_active ? 1 : 0, is_percentage: val.is_percentage ? 1 : 0 }, { signal });
    return response.data.data;
}


export const updateChargeHandler = async (id: number, val: ChargeFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ChargeType }>(api_routes.charge.update + `/${id}`, { ...val, is_active: val.is_active ? 1 : 0, is_percentage: val.is_percentage ? 1 : 0 }, { signal });
    return response.data.data;
}


export const deleteChargeHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: ChargeType }>(api_routes.charge.delete + `/${id}`, { signal });
    return response.data.data;
}


export const toggleChargeStatusHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: ChargeType }>(api_routes.charge.toggle_status + `/${id}`, { signal });
    return response.data.data;
}


export const getChargeHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: ChargeType }>(api_routes.charge.view + `/${id}`, { signal });
    return response.data.data;
}

export const getChargesHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<ChargeType>>(api_routes.charge.paginate, { params, signal });
    return response.data;
}