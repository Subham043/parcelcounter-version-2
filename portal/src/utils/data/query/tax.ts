import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, TaxType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getTaxHandler, getTaxesHandler } from "../dal/tax";
import { useSearchParams } from "react-router";


export const TaxQueryKey = (id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["tax", id, "edit"]
    }
    return ["tax", id, "view"]
};

export const TaxesQueryKey = (params: URLSearchParams) => {
    return ["taxes", params.toString()]
};

export const TaxQueryFn = async ({ id, signal }: { id: number, signal?: AbortSignal }) => {
    return await getTaxHandler(id, signal);
}

export const TaxesQueryFn = async ({ params, signal }: { params: URLSearchParams, signal?: AbortSignal }) => {
    return await getTaxesHandler(params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useTaxQuery: (id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    TaxType | undefined,
    unknown
> = (id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: TaxQueryKey(id, isEdit),
        queryFn: ({ signal }) => TaxQueryFn({ id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useTaxesQuery: () => UseQueryResult<
    PaginationType<TaxType> | undefined,
    unknown
> = () => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: TaxesQueryKey(params),
        queryFn: ({ signal }) => TaxesQueryFn({ params, signal }),
        enabled: authToken !== null,
    });
};