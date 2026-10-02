import type { GenericAbortSignal } from "axios";
import type { FeatureFormValuesType } from "../schema/feature";
import axios from "@/utils/axios";
import type { FeatureType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";


export const createFeatureHandler = async (val: FeatureFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: FeatureType }>(api_routes.feature.create, { ...val, is_active: val.is_active ? 1 : 0 }, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const updateFeatureHandler = async (id: number, val: FeatureFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: FeatureType }>(api_routes.feature.update + `/${id}`, { ...val, is_active: val.is_active ? 1 : 0 }, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const deleteFeatureHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: FeatureType }>(api_routes.feature.delete + `/${id}`, { signal });
    return response.data.data;
}


export const toggleFeatureStatusHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: FeatureType }>(api_routes.feature.toggle_status + `/${id}`, { signal });
    return response.data.data;
}


export const getFeatureHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: FeatureType }>(api_routes.feature.view + `/${id}`, { signal });
    return response.data.data;
}

export const getFeaturesHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<FeatureType>>(api_routes.feature.paginate, { params, signal });
    return response.data;
}