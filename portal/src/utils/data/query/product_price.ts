import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, ProductPriceType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getProductPriceHandler, getProductPricesHandler } from "../dal/product_price";
import { useSearchParams } from "react-router";


export const ProductPriceQueryKey = (product_id: number, id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["product-price", product_id, id, "edit"]
    }
    return ["product-price", product_id, id, "view"]
};

export const ProductPricesQueryKey = (product_id: number, params: URLSearchParams) => {
    return ["product-prices", product_id, params.toString()]
};

export const ProductPriceQueryFn = async ({ product_id, id, signal }: { product_id: number, id: number, signal?: AbortSignal }) => {
    return await getProductPriceHandler(product_id, id, signal);
}

export const ProductPricesQueryFn = async ({ product_id, params, signal }: { product_id: number, params: URLSearchParams, signal?: AbortSignal }) => {
    return await getProductPricesHandler(product_id, params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useProductPriceQuery: (product_id: number, id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    ProductPriceType | undefined,
    unknown
> = (product_id, id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: ProductPriceQueryKey(product_id, id, isEdit),
        queryFn: ({ signal }) => ProductPriceQueryFn({ product_id, id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useProductPricesQuery: (product_id: number) => UseQueryResult<
    PaginationType<ProductPriceType> | undefined,
    unknown
> = (product_id) => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: ProductPricesQueryKey(product_id, params),
        queryFn: ({ signal }) => ProductPricesQueryFn({ product_id, params, signal }),
        enabled: authToken !== null,
    });
};