import type { GenericAbortSignal } from "axios";
import type { SubCategoryFormValuesType } from "../schema/sub_category";
import axios from "@/utils/axios";
import type { SubCategoryType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";


export const createSubCategoryHandler = async (val: SubCategoryFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: SubCategoryType }>(api_routes.sub_category.create, { ...val, is_active: val.is_active ? 1 : 0, meta_keywords: val.meta_keywords && val.meta_keywords.length > 0 ? val.meta_keywords.join(",") : undefined, category: val.category.map((category) => category.value) ?? [] }, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const updateSubCategoryHandler = async (id: number, val: SubCategoryFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: SubCategoryType }>(api_routes.sub_category.update + `/${id}`, { ...val, is_active: val.is_active ? 1 : 0, meta_keywords: val.meta_keywords && val.meta_keywords.length > 0 ? val.meta_keywords.join(",") : undefined, category: val.category.map((category) => category.value) ?? [] }, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const deleteSubCategoryHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: SubCategoryType }>(api_routes.sub_category.delete + `/${id}`, { signal });
    return response.data.data;
}


export const toggleSubCategoryStatusHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: SubCategoryType }>(api_routes.sub_category.toggle_status + `/${id}`, { signal });
    return response.data.data;
}


export const getSubCategoryHandler = async (id: number, signal?: GenericAbortSignal | undefined, includeCategory: boolean = false) => {
    const params = new URLSearchParams();
    if (includeCategory) {
        params.set("include-category", "yes");
    }
    const response = await axios.get<{ data: SubCategoryType }>(api_routes.sub_category.view + `/${id}`, { params, signal });
    return response.data.data;
}

export const getSubCategoriesHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined, includeCategory: boolean = false, isSelect: boolean = false) => {
    if (includeCategory) {
        params.set("include-category", "yes");
    }
    if (isSelect) {
        params.set("is-select", "yes");
    }
    // params.set("filter[is_active]", "yes1");
    const response = await axios.get<PaginationType<SubCategoryType>>(api_routes.sub_category.paginate, { params, signal });
    return response.data;
}


export const exportSubCategoriesHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get(api_routes.sub_category.excel, { params, signal, responseType: "blob" });
    return new Blob([response.data], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
}