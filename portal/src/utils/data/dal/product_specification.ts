import type { GenericAbortSignal } from "axios";
import type { ProductSpecificationFormValuesType } from "../schema/product_specification";
import axios from "@/utils/axios";
import type { ProductSpecificationType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";

export const createProductSpecificationHandler = async (product_id: number, val: ProductSpecificationFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ProductSpecificationType }>(api_routes.product.specifications.create(product_id), val, { signal });
    return response.data.data;
}


export const updateProductSpecificationHandler = async (product_id: number, id: number, val: ProductSpecificationFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ProductSpecificationType }>(api_routes.product.specifications.update(product_id, id), val, { signal });
    return response.data.data;
}


export const deleteProductSpecificationHandler = async (product_id: number, id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: ProductSpecificationType }>(api_routes.product.specifications.delete(product_id, id), { signal });
    return response.data.data;
}

export const getProductSpecificationHandler = async (product_id: number, id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: ProductSpecificationType }>(api_routes.product.specifications.view(product_id, id), { signal });
    return response.data.data;
}

export const getProductSpecificationsHandler = async (product_id: number, params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<ProductSpecificationType>>(api_routes.product.specifications.paginate(product_id), { params, signal });
    return response.data;
}