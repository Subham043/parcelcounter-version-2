import type { GenericAbortSignal } from "axios";
import type { CategoryFormValuesType } from "../schema/category";
import axios from "@/utils/axios";
import type { CategoryType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";


export const createCategoryHandler = async (val: CategoryFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: CategoryType }>(api_routes.category.create, { ...val, is_active: val.is_active ? 1 : 0, meta_keywords: val.meta_keywords && val.meta_keywords.length > 0 ? val.meta_keywords.join(",") : undefined }, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const updateCategoryHandler = async (id: number, val: CategoryFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: CategoryType }>(api_routes.category.update + `/${id}`, { ...val, is_active: val.is_active ? 1 : 0, meta_keywords: val.meta_keywords && val.meta_keywords.length > 0 ? val.meta_keywords.join(",") : undefined }, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const deleteCategoryHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: CategoryType }>(api_routes.category.delete + `/${id}`, { signal });
    return response.data.data;
}


export const toggleCategoryStatusHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: CategoryType }>(api_routes.category.toggle_status + `/${id}`, { signal });
    return response.data.data;
}


export const getCategoryHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: CategoryType }>(api_routes.category.view + `/${id}`, { signal });
    return response.data.data;
}

export const getCategoriesHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<CategoryType>>(api_routes.category.paginate, { params, signal });
    return response.data;
}


export const exportCategoriesHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get(api_routes.category.excel, { params, signal, responseType: "blob" });
    return new Blob([response.data], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
}