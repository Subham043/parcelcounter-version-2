import type { GenericAbortSignal } from "axios";
import type { ProductFormValuesType } from "../schema/product";
import axios from "@/utils/axios";
import type { ProductType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";
import { format } from "date-fns";

const setProductValues = (val: ProductFormValuesType) => {
    return {
        ...val,
        is_active: val.is_active ? 1 : 0,
        is_new: val.is_new ? 1 : 0,
        is_on_sale: val.is_on_sale ? 1 : 0,
        is_featured: val.is_featured ? 1 : 0,
        meta_keywords: val.meta_keywords && val.meta_keywords.length > 0 ? val.meta_keywords.join(",") : undefined,
        category: val.category.map((category) => category.value) ?? [],
        sub_category: val.sub_category.map((sub_category) => sub_category.value) ?? [],
        tax: val.tax.map((tax) => tax.value) ?? [],
        specifications: val.specifications.map((specification) => specification) ?? [],
        prices: val.prices ?? [],
        stocks: val.stocks?.map((stock) => ({
            ...stock,
            purchased_at: format(stock.purchased_at, "yyyy-MM-dd")
        })) ?? [],
        colors: val.colors ?? [],
        videos: val.videos ?? [],
        images: val.images ?? [],
    }
}

export const createProductHandler = async (val: ProductFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ProductType }>(api_routes.product.create, setProductValues(val), { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const updateProductHandler = async (id: number, val: ProductFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: ProductType }>(api_routes.product.update + `/${id}`, setProductValues(val), { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const deleteProductHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: ProductType }>(api_routes.product.delete + `/${id}`, { signal });
    return response.data.data;
}


export const toggleProductStatusHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: ProductType }>(api_routes.product.toggle_status + `/${id}`, { signal });
    return response.data.data;
}

export type ProductOptionType = { includeCategory?: boolean; includeSubCategory?: boolean; includeTax?: boolean; includeSpecification?: boolean; includeImage?: boolean; includeVideo?: boolean; includeColor?: boolean; includePrice?: boolean; includeStock?: boolean; includeLatestStock?: boolean; includeReview?: boolean }

export const getProductHandler = async (id: number, signal?: GenericAbortSignal | undefined, options?: ProductOptionType) => {
    const params = new URLSearchParams();
    if (options?.includeCategory) {
        params.set("include-category", "yes");
    }
    if (options?.includeSubCategory) {
        params.set("include-sub-category", "yes");
    }
    if (options?.includeTax) {
        params.set("include-tax", "yes");
    }
    if (options?.includeSpecification) {
        params.set("include-specification", "yes");
    }
    if (options?.includeImage) {
        params.set("include-image", "yes");
    }
    if (options?.includeVideo) {
        params.set("include-video", "yes");
    }
    if (options?.includeColor) {
        params.set("include-color", "yes");
    }
    if (options?.includePrice) {
        params.set("include-price", "yes");
    }
    if (options?.includeStock) {
        params.set("include-stock", "yes");
    }
    if (options?.includeLatestStock) {
        params.set("include-latest-stock", "yes");
    }
    if (options?.includeReview) {
        params.set("include-review", "yes");
    }
    const response = await axios.get<{ data: ProductType }>(api_routes.product.view + `/${id}`, { params, signal });
    return response.data.data;
}

export const getProductsHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined, options?: ProductOptionType & { isSelect?: boolean }) => {
    if (options?.includeCategory) {
        params.set("include-category", "yes");
    }
    if (options?.includeSubCategory) {
        params.set("include-sub-category", "yes");
    }
    if (options?.includeTax) {
        params.set("include-tax", "yes");
    }
    if (options?.includeSpecification) {
        params.set("include-specification", "yes");
    }
    if (options?.includeImage) {
        params.set("include-image", "yes");
    }
    if (options?.includeVideo) {
        params.set("include-video", "yes");
    }
    if (options?.includeColor) {
        params.set("include-color", "yes");
    }
    if (options?.includePrice) {
        params.set("include-price", "yes");
    }
    if (options?.includeStock) {
        params.set("include-stock", "yes");
    }
    if (options?.includeLatestStock) {
        params.set("include-latest-stock", "yes");
    }
    if (options?.includeReview) {
        params.set("include-review", "yes");
    }
    if (options?.isSelect) {
        params.set("is-select", "yes");
    }
    const response = await axios.get<PaginationType<ProductType>>(api_routes.product.paginate, { params, signal });
    return response.data;
}


export const exportProductsHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get(api_routes.product.excel, { params, signal, responseType: "blob" });
    return new Blob([response.data], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
}