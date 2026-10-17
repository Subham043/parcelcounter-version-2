import type { GenericAbortSignal } from "axios";
import type { ProductStockFormValuesType } from "../schema/product_stock";
import axios from "@/utils/axios";
import type { ProductStockType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";
import { format } from "date-fns";

export const createProductStockHandler = async (product_id: number, val: ProductStockFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ProductStockType }>(api_routes.product.stocks.create(product_id), { ...val, purchased_at: format(val.purchased_at, "yyyy-MM-dd") }, { signal });
    return response.data.data;
}


export const updateProductStockHandler = async (product_id: number, id: number, val: ProductStockFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ProductStockType }>(api_routes.product.stocks.update(product_id, id), { ...val, purchased_at: format(val.purchased_at, "yyyy-MM-dd") }, { signal });
    return response.data.data;
}


export const deleteProductStockHandler = async (product_id: number, id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: ProductStockType }>(api_routes.product.stocks.delete(product_id, id), { signal });
    return response.data.data;
}

export const getProductStockHandler = async (product_id: number, id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: ProductStockType }>(api_routes.product.stocks.view(product_id, id), { signal });
    return response.data.data;
}

export const getProductStocksHandler = async (product_id: number, params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<ProductStockType>>(api_routes.product.stocks.paginate(product_id), { params, signal });
    return response.data;
}