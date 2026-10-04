import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, BlogType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getBlogHandler, getBlogsHandler } from "../dal/blog";
import { useSearchParams } from "react-router";


export const BlogQueryKey = (id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["blog", id, "edit"]
    }
    return ["blog", id, "view"]
};

export const BlogsQueryKey = (params: URLSearchParams) => {
    return ["blogs", params.toString()]
};

export const BlogQueryFn = async ({ id, signal }: { id: number, signal?: AbortSignal }) => {
    return await getBlogHandler(id, signal);
}

export const BlogsQueryFn = async ({ params, signal }: { params: URLSearchParams, signal?: AbortSignal }) => {
    return await getBlogsHandler(params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useBlogQuery: (id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    BlogType | undefined,
    unknown
> = (id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: BlogQueryKey(id, isEdit),
        queryFn: ({ signal }) => BlogQueryFn({ id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useBlogsQuery: () => UseQueryResult<
    PaginationType<BlogType> | undefined,
    unknown
> = () => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: BlogsQueryKey(params),
        queryFn: ({ signal }) => BlogsQueryFn({ params, signal }),
        enabled: authToken !== null,
    });
};