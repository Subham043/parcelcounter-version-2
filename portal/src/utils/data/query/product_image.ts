import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, ProductImageType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getProductImageHandler, getProductImagesHandler } from "../dal/product_image";
import { useSearchParams } from "react-router";


export const ProductImageQueryKey = (product_id: number, id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["product-image", product_id, id, "edit"]
    }
    return ["product-image", product_id, id, "view"]
};

export const ProductImagesQueryKey = (product_id: number, params: URLSearchParams) => {
    return ["product-images", product_id, params.toString()]
};

export const ProductImageQueryFn = async ({ product_id, id, signal }: { product_id: number, id: number, signal?: AbortSignal }) => {
    return await getProductImageHandler(product_id, id, signal);
}

export const ProductImagesQueryFn = async ({ product_id, params, signal }: { product_id: number, params: URLSearchParams, signal?: AbortSignal }) => {
    return await getProductImagesHandler(product_id, params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useProductImageQuery: (product_id: number, id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    ProductImageType | undefined,
    unknown
> = (product_id, id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: ProductImageQueryKey(product_id, id, isEdit),
        queryFn: ({ signal }) => ProductImageQueryFn({ product_id, id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useProductImagesQuery: (product_id: number) => UseQueryResult<
    PaginationType<ProductImageType> | undefined,
    unknown
> = (product_id) => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: ProductImagesQueryKey(product_id, params),
        queryFn: ({ signal }) => ProductImagesQueryFn({ product_id, params, signal }),
        enabled: authToken !== null,
    });
};