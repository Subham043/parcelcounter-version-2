import type { GenericAbortSignal } from "axios";
import type { CertificationFormValuesType } from "../schema/certification";
import axios from "@/utils/axios";
import type { CertificationType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";


export const createCertificationHandler = async (val: CertificationFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: CertificationType }>(api_routes.certification.create, { ...val, is_active: val.is_active ? 1 : 0 }, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const updateCertificationHandler = async (id: number, val: CertificationFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: CertificationType }>(api_routes.certification.update + `/${id}`, { ...val, is_active: val.is_active ? 1 : 0 }, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const deleteCertificationHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: CertificationType }>(api_routes.certification.delete + `/${id}`, { signal });
    return response.data.data;
}


export const toggleCertificationStatusHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: CertificationType }>(api_routes.certification.toggle_status + `/${id}`, { signal });
    return response.data.data;
}


export const getCertificationHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: CertificationType }>(api_routes.certification.view + `/${id}`, { signal });
    return response.data.data;
}

export const getCertificationsHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<CertificationType>>(api_routes.certification.paginate, { params, signal });
    return response.data;
}

export const exportCertificationsHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get(api_routes.certification.excel, { params, signal, responseType: "blob" });
    return new Blob([response.data], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
}