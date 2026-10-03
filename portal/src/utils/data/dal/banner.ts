import type { GenericAbortSignal } from "axios";
import type { BannerFormValuesType } from "../schema/banner";
import axios from "@/utils/axios";
import type { BannerType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";


export const createBannerHandler = async (val: BannerFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: BannerType }>(api_routes.banner.create, { ...val, is_active: val.is_active ? 1 : 0 }, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const updateBannerHandler = async (id: number, val: BannerFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: BannerType }>(api_routes.banner.update + `/${id}`, { ...val, is_active: val.is_active ? 1 : 0 }, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const deleteBannerHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: BannerType }>(api_routes.banner.delete + `/${id}`, { signal });
    return response.data.data;
}


export const toggleBannerStatusHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: BannerType }>(api_routes.banner.toggle_status + `/${id}`, { signal });
    return response.data.data;
}


export const getBannerHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: BannerType }>(api_routes.banner.view + `/${id}`, { signal });
    return response.data.data;
}

export const getBannersHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<BannerType>>(api_routes.banner.paginate, { params, signal });
    return response.data;
}