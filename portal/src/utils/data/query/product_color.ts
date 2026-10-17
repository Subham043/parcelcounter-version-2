import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, ProductColorType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getProductColorHandler, getProductColorsHandler } from "../dal/product_color";
import { useSearchParams } from "react-router";


export const ProductColorQueryKey = (product_id: number, id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["product-color", product_id, id, "edit"]
    }
    return ["product-color", product_id, id, "view"]
};

export const ProductColorsQueryKey = (product_id: number, params: URLSearchParams) => {
    return ["product-colors", product_id, params.toString()]
};

export const ProductColorQueryFn = async ({ product_id, id, signal }: { product_id: number, id: number, signal?: AbortSignal }) => {
    return await getProductColorHandler(product_id, id, signal);
}

export const ProductColorsQueryFn = async ({ product_id, params, signal }: { product_id: number, params: URLSearchParams, signal?: AbortSignal }) => {
    return await getProductColorsHandler(product_id, params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useProductColorQuery: (product_id: number, id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    ProductColorType | undefined,
    unknown
> = (product_id, id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: ProductColorQueryKey(product_id, id, isEdit),
        queryFn: ({ signal }) => ProductColorQueryFn({ product_id, id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useProductColorsQuery: (product_id: number) => UseQueryResult<
    PaginationType<ProductColorType> | undefined,
    unknown
> = (product_id) => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: ProductColorsQueryKey(product_id, params),
        queryFn: ({ signal }) => ProductColorsQueryFn({ product_id, params, signal }),
        enabled: authToken !== null,
    });
};