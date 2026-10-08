import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, ProductType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getProductHandler, getProductsHandler, type ProductOptionType } from "../dal/product";
import { useSearchParams } from "react-router";

export const ProductQueryKey = (id: number, options?: ProductOptionType, isEdit: boolean = false) => {
    if (isEdit) {
        return ["product", id, options, "edit"]
    }
    return ["product", id, options, "view"]
};

export const ProductsQueryKey = (params: URLSearchParams, options?: ProductOptionType & { isSelect?: boolean }) => {
    return ["products", params.toString(), { ...options }]
};

export const ProductQueryFn = async ({ id, signal, options }: { id: number, signal?: AbortSignal, options?: ProductOptionType }) => {
    return await getProductHandler(id, signal, options);
}

export const ProductsQueryFn = async ({ params, signal, options }: { params: URLSearchParams, signal?: AbortSignal, options?: ProductOptionType & { isSelect?: boolean } }) => {
    return await getProductsHandler(params, signal, options);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useProductQuery: (id: number, enabled: boolean, options?: ProductOptionType, isEdit?: boolean) => UseQueryResult<
    ProductType | undefined,
    unknown
> = (id, enabled, options, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: ProductQueryKey(id, options, isEdit),
        queryFn: ({ signal }) => ProductQueryFn({ id, signal, options }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useProductsQuery: (options?: ProductOptionType & { isSelect?: boolean }) => UseQueryResult<
    PaginationType<ProductType> | undefined,
    unknown
> = (options) => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: ProductsQueryKey(params, options),
        queryFn: ({ signal }) => ProductsQueryFn({ params, signal, options }),
        enabled: authToken !== null,
    });
};