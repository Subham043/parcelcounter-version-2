import type { GenericAbortSignal } from "axios";
import type { AboutSectionFormValuesType } from "../schema/about_section";
import axios from "@/utils/axios";
import type { AboutSectionType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";


export const createAboutSectionHandler = async (val: AboutSectionFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: AboutSectionType }>(api_routes.about_section.create, { ...val, is_active: val.is_active ? 1 : 0 }, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const updateAboutSectionHandler = async (id: number, val: AboutSectionFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: AboutSectionType }>(api_routes.about_section.update + `/${id}`, { ...val, is_active: val.is_active ? 1 : 0 }, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const deleteAboutSectionHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: AboutSectionType }>(api_routes.about_section.delete + `/${id}`, { signal });
    return response.data.data;
}


export const toggleAboutSectionStatusHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: AboutSectionType }>(api_routes.about_section.toggle_status + `/${id}`, { signal });
    return response.data.data;
}


export const getAboutSectionHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: AboutSectionType }>(api_routes.about_section.view + `/${id}`, { signal });
    return response.data.data;
}

export const getAboutSectionsHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<AboutSectionType>>(api_routes.about_section.paginate, { params, signal });
    return response.data;
}


export const exportAboutSectionsHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get(api_routes.about_section.excel, { params, signal, responseType: "blob" });
    return new Blob([response.data], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
}