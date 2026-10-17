import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, ProductReviewType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getProductReviewHandler, getProductReviewsHandler } from "../dal/product_review";
import { useSearchParams } from "react-router";


export const ProductReviewQueryKey = (product_id: number, id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["product-review", product_id, id, "edit"]
    }
    return ["product-review", product_id, id, "view"]
};

export const ProductReviewsQueryKey = (product_id: number, params: URLSearchParams) => {
    return ["product-reviews", product_id, params.toString()]
};

export const ProductReviewQueryFn = async ({ product_id, id, signal }: { product_id: number, id: number, signal?: AbortSignal }) => {
    return await getProductReviewHandler(product_id, id, signal);
}

export const ProductReviewsQueryFn = async ({ product_id, params, signal }: { product_id: number, params: URLSearchParams, signal?: AbortSignal }) => {
    return await getProductReviewsHandler(product_id, params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useProductReviewQuery: (product_id: number, id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    ProductReviewType | undefined,
    unknown
> = (product_id, id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: ProductReviewQueryKey(product_id, id, isEdit),
        queryFn: ({ signal }) => ProductReviewQueryFn({ product_id, id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useProductReviewsQuery: (product_id: number) => UseQueryResult<
    PaginationType<ProductReviewType> | undefined,
    unknown
> = (product_id) => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: ProductReviewsQueryKey(product_id, params),
        queryFn: ({ signal }) => ProductReviewsQueryFn({ product_id, params, signal }),
        enabled: authToken !== null,
    });
};