import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, CategoryType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getCategoryHandler, getCategoriesHandler } from "../dal/category";
import { useSearchParams } from "react-router";


export const CategoryQueryKey = (id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["category", id, "edit"]
    }
    return ["category", id, "view"]
};

export const CategoriesQueryKey = (params: URLSearchParams, isSelect: boolean) => {
    return ["categories", params.toString(), isSelect]
};

export const CategoryQueryFn = async ({ id, signal }: { id: number, signal?: AbortSignal }) => {
    return await getCategoryHandler(id, signal);
}

export const CategoriesQueryFn = async ({ params, signal, isSelect }: { params: URLSearchParams, signal?: AbortSignal, isSelect: boolean }) => {
    return await getCategoriesHandler(params, signal, isSelect);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useCategoryQuery: (id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    CategoryType | undefined,
    unknown
> = (id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: CategoryQueryKey(id, isEdit),
        queryFn: ({ signal }) => CategoryQueryFn({ id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useCategoriesQuery: (isSelect?: boolean) => UseQueryResult<
    PaginationType<CategoryType> | undefined,
    unknown
> = (isSelect = false) => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: CategoriesQueryKey(params, isSelect),
        queryFn: ({ signal }) => CategoriesQueryFn({ params, isSelect, signal }),
        enabled: authToken !== null,
    });
};