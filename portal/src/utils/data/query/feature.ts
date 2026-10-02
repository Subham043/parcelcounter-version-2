import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, FeatureType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getFeatureHandler, getFeaturesHandler } from "../dal/feature";
import { useSearchParams } from "react-router";


export const FeatureQueryKey = (id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["feature", id, "edit"]
    }
    return ["feature", id, "view"]
};

export const FeaturesQueryKey = (params: URLSearchParams) => {
    return ["features", params.toString()]
};

export const FeatureQueryFn = async ({ id, signal }: { id: number, signal?: AbortSignal }) => {
    return await getFeatureHandler(id, signal);
}

export const FeaturesQueryFn = async ({ params, signal }: { params: URLSearchParams, signal?: AbortSignal }) => {
    return await getFeaturesHandler(params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useFeatureQuery: (id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    FeatureType | undefined,
    unknown
> = (id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: FeatureQueryKey(id, isEdit),
        queryFn: ({ signal }) => FeatureQueryFn({ id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useFeaturesQuery: () => UseQueryResult<
    PaginationType<FeatureType> | undefined,
    unknown
> = () => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: FeaturesQueryKey(params),
        queryFn: ({ signal }) => FeaturesQueryFn({ params, signal }),
        enabled: authToken !== null,
    });
};