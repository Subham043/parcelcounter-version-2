import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, PaymentOptionType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getPaymentOptionHandler, getPaymentOptionsHandler } from "../dal/payment_option";
import { useSearchParams } from "react-router";


export const PaymentOptionQueryKey = (id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["payment_option", id, "edit"]
    }
    return ["payment_option", id, "view"]
};

export const PaymentOptionsQueryKey = (params: URLSearchParams) => {
    return ["payment_options", params.toString()]
};

export const PaymentOptionQueryFn = async ({ id, signal }: { id: number, signal?: AbortSignal }) => {
    return await getPaymentOptionHandler(id, signal);
}

export const PaymentOptionsQueryFn = async ({ params, signal }: { params: URLSearchParams, signal?: AbortSignal }) => {
    return await getPaymentOptionsHandler(params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const usePaymentOptionQuery: (id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    PaymentOptionType | undefined,
    unknown
> = (id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: PaymentOptionQueryKey(id, isEdit),
        queryFn: ({ signal }) => PaymentOptionQueryFn({ id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const usePaymentOptionsQuery: () => UseQueryResult<
    PaginationType<PaymentOptionType> | undefined,
    unknown
> = () => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: PaymentOptionsQueryKey(params),
        queryFn: ({ signal }) => PaymentOptionsQueryFn({ params, signal }),
        enabled: authToken !== null,
    });
};