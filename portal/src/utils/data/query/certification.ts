import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, CertificationType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getCertificationHandler, getCertificationsHandler } from "../dal/certification";
import { useSearchParams } from "react-router";


export const CertificationQueryKey = (id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["certification", id, "edit"]
    }
    return ["certification", id, "view"]
};

export const CertificationsQueryKey = (params: URLSearchParams) => {
    return ["certifications", params.toString()]
};

export const CertificationQueryFn = async ({ id, signal }: { id: number, signal?: AbortSignal }) => {
    return await getCertificationHandler(id, signal);
}

export const CertificationsQueryFn = async ({ params, signal }: { params: URLSearchParams, signal?: AbortSignal }) => {
    return await getCertificationsHandler(params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useCertificationQuery: (id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    CertificationType | undefined,
    unknown
> = (id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: CertificationQueryKey(id, isEdit),
        queryFn: ({ signal }) => CertificationQueryFn({ id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useCertificationsQuery: () => UseQueryResult<
    PaginationType<CertificationType> | undefined,
    unknown
> = () => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: CertificationsQueryKey(params),
        queryFn: ({ signal }) => CertificationsQueryFn({ params, signal }),
        enabled: authToken !== null,
    });
};