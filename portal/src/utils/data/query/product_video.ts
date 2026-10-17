import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, ProductVideoType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getProductVideoHandler, getProductVideosHandler } from "../dal/product_video";
import { useSearchParams } from "react-router";


export const ProductVideoQueryKey = (product_id: number, id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["product-video", product_id, id, "edit"]
    }
    return ["product-video", product_id, id, "view"]
};

export const ProductVideosQueryKey = (product_id: number, params: URLSearchParams) => {
    return ["product-videos", product_id, params.toString()]
};

export const ProductVideoQueryFn = async ({ product_id, id, signal }: { product_id: number, id: number, signal?: AbortSignal }) => {
    return await getProductVideoHandler(product_id, id, signal);
}

export const ProductVideosQueryFn = async ({ product_id, params, signal }: { product_id: number, params: URLSearchParams, signal?: AbortSignal }) => {
    return await getProductVideosHandler(product_id, params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useProductVideoQuery: (product_id: number, id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    ProductVideoType | undefined,
    unknown
> = (product_id, id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: ProductVideoQueryKey(product_id, id, isEdit),
        queryFn: ({ signal }) => ProductVideoQueryFn({ product_id, id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useProductVideosQuery: (product_id: number) => UseQueryResult<
    PaginationType<ProductVideoType> | undefined,
    unknown
> = (product_id) => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: ProductVideosQueryKey(product_id, params),
        queryFn: ({ signal }) => ProductVideosQueryFn({ product_id, params, signal }),
        enabled: authToken !== null,
    });
};