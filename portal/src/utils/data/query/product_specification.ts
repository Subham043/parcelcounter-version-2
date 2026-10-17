import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, ProductSpecificationType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getProductSpecificationHandler, getProductSpecificationsHandler } from "../dal/product_specification";
import { useSearchParams } from "react-router";


export const ProductSpecificationQueryKey = (product_id: number, id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["product-specification", product_id, id, "edit"]
    }
    return ["product-specification", product_id, id, "view"]
};

export const ProductSpecificationsQueryKey = (product_id: number, params: URLSearchParams) => {
    return ["product-specifications", product_id, params.toString()]
};

export const ProductSpecificationQueryFn = async ({ product_id, id, signal }: { product_id: number, id: number, signal?: AbortSignal }) => {
    return await getProductSpecificationHandler(product_id, id, signal);
}

export const ProductSpecificationsQueryFn = async ({ product_id, params, signal }: { product_id: number, params: URLSearchParams, signal?: AbortSignal }) => {
    return await getProductSpecificationsHandler(product_id, params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useProductSpecificationQuery: (product_id: number, id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    ProductSpecificationType | undefined,
    unknown
> = (product_id, id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: ProductSpecificationQueryKey(product_id, id, isEdit),
        queryFn: ({ signal }) => ProductSpecificationQueryFn({ product_id, id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useProductSpecificationsQuery: (product_id: number) => UseQueryResult<
    PaginationType<ProductSpecificationType> | undefined,
    unknown
> = (product_id) => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: ProductSpecificationsQueryKey(product_id, params),
        queryFn: ({ signal }) => ProductSpecificationsQueryFn({ product_id, params, signal }),
        enabled: authToken !== null,
    });
};