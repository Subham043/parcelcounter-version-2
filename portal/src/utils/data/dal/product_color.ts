import type { GenericAbortSignal } from "axios";
import type { ProductColorFormValuesType } from "../schema/product_color";
import axios from "@/utils/axios";
import type { ProductColorType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";

export const createProductColorHandler = async (product_id: number, val: ProductColorFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ProductColorType }>(api_routes.product.colors.create(product_id), val, { signal });
    return response.data.data;
}


export const updateProductColorHandler = async (product_id: number, id: number, val: ProductColorFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ProductColorType }>(api_routes.product.colors.update(product_id, id), val, { signal });
    return response.data.data;
}


export const deleteProductColorHandler = async (product_id: number, id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: ProductColorType }>(api_routes.product.colors.delete(product_id, id), { signal });
    return response.data.data;
}

export const getProductColorHandler = async (product_id: number, id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: ProductColorType }>(api_routes.product.colors.view(product_id, id), { signal });
    return response.data.data;
}

export const getProductColorsHandler = async (product_id: number, params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<ProductColorType>>(api_routes.product.colors.paginate(product_id), { params, signal });
    return response.data;
}