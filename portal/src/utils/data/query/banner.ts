import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, BannerType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getBannerHandler, getBannersHandler } from "../dal/banner";
import { useSearchParams } from "react-router";


export const BannerQueryKey = (id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["banner", id, "edit"]
    }
    return ["banner", id, "view"]
};

export const BannersQueryKey = (params: URLSearchParams) => {
    return ["banners", params.toString()]
};

export const BannerQueryFn = async ({ id, signal }: { id: number, signal?: AbortSignal }) => {
    return await getBannerHandler(id, signal);
}

export const BannersQueryFn = async ({ params, signal }: { params: URLSearchParams, signal?: AbortSignal }) => {
    return await getBannersHandler(params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useBannerQuery: (id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    BannerType | undefined,
    unknown
> = (id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: BannerQueryKey(id, isEdit),
        queryFn: ({ signal }) => BannerQueryFn({ id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useBannersQuery: () => UseQueryResult<
    PaginationType<BannerType> | undefined,
    unknown
> = () => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: BannersQueryKey(params),
        queryFn: ({ signal }) => BannersQueryFn({ params, signal }),
        enabled: authToken !== null,
    });
};