import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, ProductStockType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getProductStockHandler, getProductStocksHandler } from "../dal/product_stock";
import { useSearchParams } from "react-router";


export const ProductStockQueryKey = (product_id: number, id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["product-stock", product_id, id, "edit"]
    }
    return ["product-stock", product_id, id, "view"]
};

export const ProductStocksQueryKey = (product_id: number, params: URLSearchParams) => {
    return ["product-stocks", product_id, params.toString()]
};

export const ProductStockQueryFn = async ({ product_id, id, signal }: { product_id: number, id: number, signal?: AbortSignal }) => {
    return await getProductStockHandler(product_id, id, signal);
}

export const ProductStocksQueryFn = async ({ product_id, params, signal }: { product_id: number, params: URLSearchParams, signal?: AbortSignal }) => {
    return await getProductStocksHandler(product_id, params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useProductStockQuery: (product_id: number, id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    ProductStockType | undefined,
    unknown
> = (product_id, id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: ProductStockQueryKey(product_id, id, isEdit),
        queryFn: ({ signal }) => ProductStockQueryFn({ product_id, id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useProductStocksQuery: (product_id: number) => UseQueryResult<
    PaginationType<ProductStockType> | undefined,
    unknown
> = (product_id) => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: ProductStocksQueryKey(product_id, params),
        queryFn: ({ signal }) => ProductStocksQueryFn({ product_id, params, signal }),
        enabled: authToken !== null,
    });
};