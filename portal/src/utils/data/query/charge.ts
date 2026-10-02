import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, ChargeType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getChargeHandler, getChargesHandler } from "../dal/charge";
import { useSearchParams } from "react-router";


export const ChargeQueryKey = (id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["charge", id, "edit"]
    }
    return ["charge", id, "view"]
};

export const ChargesQueryKey = (params: URLSearchParams) => {
    return ["charges", params.toString()]
};

export const ChargeQueryFn = async ({ id, signal }: { id: number, signal?: AbortSignal }) => {
    return await getChargeHandler(id, signal);
}

export const ChargesQueryFn = async ({ params, signal }: { params: URLSearchParams, signal?: AbortSignal }) => {
    return await getChargesHandler(params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useChargeQuery: (id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    ChargeType | undefined,
    unknown
> = (id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: ChargeQueryKey(id, isEdit),
        queryFn: ({ signal }) => ChargeQueryFn({ id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useChargesQuery: () => UseQueryResult<
    PaginationType<ChargeType> | undefined,
    unknown
> = () => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: ChargesQueryKey(params),
        queryFn: ({ signal }) => ChargesQueryFn({ params, signal }),
        enabled: authToken !== null,
    });
};