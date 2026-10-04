import type { GenericAbortSignal } from "axios";
import type { LegalContentFormValuesType } from "../schema/legal_content";
import axios from "@/utils/axios";
import type { LegalContentType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";


export const createLegalContentHandler = async (val: LegalContentFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: LegalContentType }>(api_routes.legal_content.create, { ...val, is_active: val.is_active ? 1 : 0, meta_keywords: val.meta_keywords && val.meta_keywords.length > 0 ? val.meta_keywords.join(",") : undefined }, { signal });
    return response.data.data;
}


export const updateLegalContentHandler = async (id: number, val: LegalContentFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: LegalContentType }>(api_routes.legal_content.update + `/${id}`, { ...val, is_active: val.is_active ? 1 : 0, meta_keywords: val.meta_keywords && val.meta_keywords.length > 0 ? val.meta_keywords.join(",") : undefined }, { signal });
    return response.data.data;
}


export const deleteLegalContentHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: LegalContentType }>(api_routes.legal_content.delete + `/${id}`, { signal });
    return response.data.data;
}


export const toggleLegalContentStatusHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: LegalContentType }>(api_routes.legal_content.toggle_status + `/${id}`, { signal });
    return response.data.data;
}


export const getLegalContentHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: LegalContentType }>(api_routes.legal_content.view + `/${id}`, { signal });
    return response.data.data;
}

export const getLegalContentsHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<LegalContentType>>(api_routes.legal_content.paginate, { params, signal });
    return response.data;
}


export const exportLegalContentsHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get(api_routes.legal_content.excel, { params, signal, responseType: "blob" });
    return new Blob([response.data], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
}