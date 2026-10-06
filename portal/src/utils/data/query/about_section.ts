import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, AboutSectionType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getAboutSectionHandler, getAboutSectionsHandler } from "../dal/about_section";
import { useSearchParams } from "react-router";


export const AboutSectionQueryKey = (id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["about-section", id, "edit"]
    }
    return ["about-section", id, "view"]
};

export const AboutSectionsQueryKey = (params: URLSearchParams) => {
    return ["about-sections", params.toString()]
};

export const AboutSectionQueryFn = async ({ id, signal }: { id: number, signal?: AbortSignal }) => {
    return await getAboutSectionHandler(id, signal);
}

export const AboutSectionsQueryFn = async ({ params, signal }: { params: URLSearchParams, signal?: AbortSignal }) => {
    return await getAboutSectionsHandler(params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useAboutSectionQuery: (id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    AboutSectionType | undefined,
    unknown
> = (id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: AboutSectionQueryKey(id, isEdit),
        queryFn: ({ signal }) => AboutSectionQueryFn({ id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useAboutSectionsQuery: () => UseQueryResult<
    PaginationType<AboutSectionType> | undefined,
    unknown
> = () => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: AboutSectionsQueryKey(params),
        queryFn: ({ signal }) => AboutSectionsQueryFn({ params, signal }),
        enabled: authToken !== null,
    });
};