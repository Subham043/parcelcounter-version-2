import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, TestimonialType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getTestimonialHandler, getTestimonialsHandler } from "../dal/testimonial";
import { useSearchParams } from "react-router";


export const TestimonialQueryKey = (id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["testimonial", id, "edit"]
    }
    return ["testimonial", id, "view"]
};

export const TestimonialsQueryKey = (params: URLSearchParams) => {
    return ["testimonials", params.toString()]
};

export const TestimonialQueryFn = async ({ id, signal }: { id: number, signal?: AbortSignal }) => {
    return await getTestimonialHandler(id, signal);
}

export const TestimonialsQueryFn = async ({ params, signal }: { params: URLSearchParams, signal?: AbortSignal }) => {
    return await getTestimonialsHandler(params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useTestimonialQuery: (id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    TestimonialType | undefined,
    unknown
> = (id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: TestimonialQueryKey(id, isEdit),
        queryFn: ({ signal }) => TestimonialQueryFn({ id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useTestimonialsQuery: () => UseQueryResult<
    PaginationType<TestimonialType> | undefined,
    unknown
> = () => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: TestimonialsQueryKey(params),
        queryFn: ({ signal }) => TestimonialsQueryFn({ params, signal }),
        enabled: authToken !== null,
    });
};