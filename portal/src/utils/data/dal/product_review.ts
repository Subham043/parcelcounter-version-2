import type { GenericAbortSignal } from "axios";
import type { ProductReviewFormValuesType } from "../schema/product_review";
import axios from "@/utils/axios";
import type { ProductReviewType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";

export const createProductReviewHandler = async (product_id: number, val: ProductReviewFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ProductReviewType }>(api_routes.product.reviews.create(product_id), val, { signal });
    return response.data.data;
}


export const updateProductReviewHandler = async (product_id: number, id: number, val: ProductReviewFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ProductReviewType }>(api_routes.product.reviews.update(product_id, id), val, { signal });
    return response.data.data;
}


export const deleteProductReviewHandler = async (product_id: number, id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: ProductReviewType }>(api_routes.product.reviews.delete(product_id, id), { signal });
    return response.data.data;
}

export const toggleProductReviewStatusHandler = async (product_id: number, id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: ProductReviewType }>(api_routes.product.reviews.toggle_status(product_id, id), { signal });
    return response.data.data;
}

export const getProductReviewHandler = async (product_id: number, id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: ProductReviewType }>(api_routes.product.reviews.view(product_id, id), { signal });
    return response.data.data;
}

export const getProductReviewsHandler = async (product_id: number, params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<ProductReviewType>>(api_routes.product.reviews.paginate(product_id), { params, signal });
    return response.data;
}