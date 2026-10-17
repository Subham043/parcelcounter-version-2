import type { GenericAbortSignal } from "axios";
import type { ProductVideoFormValuesType } from "../schema/product_video";
import axios from "@/utils/axios";
import type { ProductVideoType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";

export const createProductVideoHandler = async (product_id: number, val: ProductVideoFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ProductVideoType }>(api_routes.product.videos.create(product_id), val, { signal });
    return response.data.data;
}


export const updateProductVideoHandler = async (product_id: number, id: number, val: ProductVideoFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ProductVideoType }>(api_routes.product.videos.update(product_id, id), val, { signal });
    return response.data.data;
}


export const deleteProductVideoHandler = async (product_id: number, id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: ProductVideoType }>(api_routes.product.videos.delete(product_id, id), { signal });
    return response.data.data;
}

export const getProductVideoHandler = async (product_id: number, id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: ProductVideoType }>(api_routes.product.videos.view(product_id, id), { signal });
    return response.data.data;
}

export const getProductVideosHandler = async (product_id: number, params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<ProductVideoType>>(api_routes.product.videos.paginate(product_id), { params, signal });
    return response.data;
}