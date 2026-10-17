import type { GenericAbortSignal } from "axios";
import type { ProductPriceFormValuesType } from "../schema/product_price";
import axios from "@/utils/axios";
import type { ProductPriceType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";

export const createProductPriceHandler = async (product_id: number, val: ProductPriceFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ProductPriceType }>(api_routes.product.prices.create(product_id), val, { signal });
    return response.data.data;
}


export const updateProductPriceHandler = async (product_id: number, id: number, val: ProductPriceFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ProductPriceType }>(api_routes.product.prices.update(product_id, id), val, { signal });
    return response.data.data;
}


export const deleteProductPriceHandler = async (product_id: number, id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: ProductPriceType }>(api_routes.product.prices.delete(product_id, id), { signal });
    return response.data.data;
}

export const getProductPriceHandler = async (product_id: number, id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: ProductPriceType }>(api_routes.product.prices.view(product_id, id), { signal });
    return response.data.data;
}

export const getProductPricesHandler = async (product_id: number, params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<ProductPriceType>>(api_routes.product.prices.paginate(product_id), { params, signal });
    return response.data;
}