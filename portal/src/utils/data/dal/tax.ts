import type { GenericAbortSignal } from "axios";
import type { TaxFormValuesType } from "../schema/tax";
import axios from "@/utils/axios";
import type { TaxType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";


export const createTaxHandler = async (val: TaxFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: TaxType }>(api_routes.tax.create, { ...val, is_active: val.is_active ? 1 : 0, is_inter_state_tax: val.is_inter_state_tax ? 1 : 0 }, { signal });
    return response.data.data;
}


export const updateTaxHandler = async (id: number, val: TaxFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: TaxType }>(api_routes.tax.update + `/${id}`, { ...val, is_active: val.is_active ? 1 : 0, is_inter_state_tax: val.is_inter_state_tax ? 1 : 0 }, { signal });
    return response.data.data;
}


export const deleteTaxHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: TaxType }>(api_routes.tax.delete + `/${id}`, { signal });
    return response.data.data;
}


export const toggleTaxStatusHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: TaxType }>(api_routes.tax.toggle_status + `/${id}`, { signal });
    return response.data.data;
}


export const getTaxHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: TaxType }>(api_routes.tax.view + `/${id}`, { signal });
    return response.data.data;
}

export const getTaxesHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<TaxType>>(api_routes.tax.paginate, { params, signal });
    return response.data;
}