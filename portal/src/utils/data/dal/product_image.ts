import type { GenericAbortSignal } from "axios";
import type { ProductImageFormValuesType } from "../schema/product_image";
import axios from "@/utils/axios";
import type { ProductImageType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";

export const createProductImageHandler = async (product_id: number, val: ProductImageFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ProductImageType }>(api_routes.product.images.create(product_id), val, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const updateProductImageHandler = async (product_id: number, id: number, val: ProductImageFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ProductImageType }>(api_routes.product.images.update(product_id, id), val, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const deleteProductImageHandler = async (product_id: number, id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: ProductImageType }>(api_routes.product.images.delete(product_id, id), { signal });
    return response.data.data;
}

export const getProductImageHandler = async (product_id: number, id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: ProductImageType }>(api_routes.product.images.view(product_id, id), { signal });
    return response.data.data;
}

export const getProductImagesHandler = async (product_id: number, params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<ProductImageType>>(api_routes.product.images.paginate(product_id), { params, signal });
    return response.data;
}