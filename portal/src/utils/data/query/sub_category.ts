import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, SubCategoryType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getSubCategoryHandler, getSubCategoriesHandler } from "../dal/sub_category";
import { useSearchParams } from "react-router";


export const SubCategoryQueryKey = (id: number, includeCategory: boolean = false, isEdit: boolean = false) => {
    if (isEdit) {
        return ["sub_category", id, includeCategory, "edit"]
    }
    return ["sub_category", id, includeCategory, "view"]
};

export const SubCategoriesQueryKey = (params: URLSearchParams, includeCategory: boolean, isSelect: boolean) => {
    return ["sub_categories", params.toString(), includeCategory, isSelect]
};

export const SubCategoryQueryFn = async ({ id, signal, includeCategory }: { id: number, signal?: AbortSignal, includeCategory: boolean }) => {
    return await getSubCategoryHandler(id, signal, includeCategory);
}

export const SubCategoriesQueryFn = async ({ params, signal, includeCategory, isSelect }: { params: URLSearchParams, signal?: AbortSignal, includeCategory: boolean, isSelect: boolean }) => {
    return await getSubCategoriesHandler(params, signal, includeCategory, isSelect);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useSubCategoryQuery: (id: number, enabled: boolean, includeCategory?: boolean, isEdit?: boolean) => UseQueryResult<
    SubCategoryType | undefined,
    unknown
> = (id, enabled, includeCategory = false, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: SubCategoryQueryKey(id, includeCategory, isEdit),
        queryFn: ({ signal }) => SubCategoryQueryFn({ id, signal, includeCategory }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useSubCategoriesQuery: (includeCategory?: boolean, isSelect?: boolean) => UseQueryResult<
    PaginationType<SubCategoryType> | undefined,
    unknown
> = (includeCategory = false, isSelect = false) => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: SubCategoriesQueryKey(params, includeCategory, isSelect),
        queryFn: ({ signal }) => SubCategoriesQueryFn({ params, signal, includeCategory, isSelect }),
        enabled: authToken !== null,
    });
};