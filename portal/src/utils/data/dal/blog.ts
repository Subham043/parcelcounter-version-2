import type { GenericAbortSignal } from "axios";
import type { BlogFormValuesType } from "../schema/blog";
import axios from "@/utils/axios";
import type { BlogType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";


export const createBlogHandler = async (val: BlogFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: BlogType }>(api_routes.blog.create, { ...val, is_active: val.is_active ? 1 : 0, is_popular: val.is_popular ? 1 : 0, meta_keywords: val.meta_keywords && val.meta_keywords.length > 0 ? val.meta_keywords.join(",") : undefined }, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const updateBlogHandler = async (id: number, val: BlogFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: BlogType }>(api_routes.blog.update + `/${id}`, { ...val, is_active: val.is_active ? 1 : 0, is_popular: val.is_popular ? 1 : 0, meta_keywords: val.meta_keywords && val.meta_keywords.length > 0 ? val.meta_keywords.join(",") : undefined }, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const deleteBlogHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: BlogType }>(api_routes.blog.delete + `/${id}`, { signal });
    return response.data.data;
}


export const toggleBlogStatusHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: BlogType }>(api_routes.blog.toggle_status + `/${id}`, { signal });
    return response.data.data;
}


export const getBlogHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: BlogType }>(api_routes.blog.view + `/${id}`, { signal });
    return response.data.data;
}

export const getBlogsHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<BlogType>>(api_routes.blog.paginate, { params, signal });
    return response.data;
}


export const exportBlogsHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get(api_routes.blog.excel, { params, signal, responseType: "blob" });
    return new Blob([response.data], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
}