import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, SubCategoryType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getSubCategoryHandler, getSubCategoriesHandler, type SubCategoryOptionType } from "../dal/sub_category";
import { useSearchParams } from "react-router";


export const SubCategoryQueryKey = (id: number, options?: SubCategoryOptionType, isEdit: boolean = false) => {
    if (isEdit) {
        return ["sub_category", id, options, "edit"]
    }
    return ["sub_category", id, options, "view"]
};

export const SubCategoriesQueryKey = (params: URLSearchParams, options?: SubCategoryOptionType & { isSelect?: boolean }) => {
    return ["sub_categories", params.toString(), { ...options }]
};

export const SubCategoryQueryFn = async ({ id, signal, options }: { id: number, signal?: AbortSignal, options?: SubCategoryOptionType }) => {
    return await getSubCategoryHandler(id, signal, options);
}

export const SubCategoriesQueryFn = async ({ params, signal, options }: { params: URLSearchParams, signal?: AbortSignal, options?: SubCategoryOptionType & { isSelect?: boolean } }) => {
    return await getSubCategoriesHandler(params, signal, options);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useSubCategoryQuery: (id: number, enabled: boolean, options?: SubCategoryOptionType, isEdit?: boolean) => UseQueryResult<
    SubCategoryType | undefined,
    unknown
> = (id, enabled, options, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: SubCategoryQueryKey(id, options, isEdit),
        queryFn: ({ signal }) => SubCategoryQueryFn({ id, signal, options }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useSubCategoriesQuery: (options?: SubCategoryOptionType & { isSelect?: boolean }) => UseQueryResult<
    PaginationType<SubCategoryType> | undefined,
    unknown
> = (options) => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: SubCategoriesQueryKey(params, options),
        queryFn: ({ signal }) => SubCategoriesQueryFn({ params, signal, options }),
        enabled: authToken !== null,
    });
};