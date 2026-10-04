import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, LegalContentType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getLegalContentHandler, getLegalContentsHandler } from "../dal/legal_content";
import { useSearchParams } from "react-router";


export const LegalContentQueryKey = (id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["legal_content", id, "edit"]
    }
    return ["legal_content", id, "view"]
};

export const LegalContentsQueryKey = (params: URLSearchParams) => {
    return ["legal_contents", params.toString()]
};

export const LegalContentQueryFn = async ({ id, signal }: { id: number, signal?: AbortSignal }) => {
    return await getLegalContentHandler(id, signal);
}

export const LegalContentsQueryFn = async ({ params, signal }: { params: URLSearchParams, signal?: AbortSignal }) => {
    return await getLegalContentsHandler(params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useLegalContentQuery: (id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    LegalContentType | undefined,
    unknown
> = (id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: LegalContentQueryKey(id, isEdit),
        queryFn: ({ signal }) => LegalContentQueryFn({ id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useLegalContentsQuery: () => UseQueryResult<
    PaginationType<LegalContentType> | undefined,
    unknown
> = () => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: LegalContentsQueryKey(params),
        queryFn: ({ signal }) => LegalContentsQueryFn({ params, signal }),
        enabled: authToken !== null,
    });
};