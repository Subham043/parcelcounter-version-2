import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { TestimonialFormValuesType } from "../schema/testimonial";
import { createTestimonialHandler, deleteTestimonialHandler, toggleTestimonialStatusHandler, updateTestimonialHandler } from "../dal/testimonial";
import type { PaginationType, TestimonialType } from "@/utils/types";
import { TestimonialQueryKey, TestimonialsQueryKey } from "../query/testimonial";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";

export const useTestimonialCreateMutation = () => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: TestimonialFormValuesType) => {
            return await createTestimonialHandler(val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Testimonial created successfully");
            // context.client.invalidateQueries({ queryKey: TestimonialsQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(TestimonialsQueryKey(params), (oldData: PaginationType<TestimonialType> | undefined) => {
                    if (!oldData) return oldData;
                    if (oldData.data.length < total) {
                        return {
                            ...oldData,
                            data: [data, ...oldData.data],
                            meta: {
                                ...oldData.meta,
                                total: oldData.meta.total + 1,
                            },
                        };
                    } else {
                        const newData = [...oldData.data];
                        newData.splice(total - 1, 0, data);
                        return {
                            ...oldData,
                            data: [data, ...newData],
                            meta: {
                                ...oldData.meta,
                                total: oldData.meta.total + 1,
                            },
                        };
                    }
                });
            } else {
                context.client.invalidateQueries({ queryKey: TestimonialsQueryKey(params) });
            }
        },
    });
};

export const useTestimonialUpdateMutation = (id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: TestimonialFormValuesType) => {
            return await updateTestimonialHandler(id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Testimonial updated successfully");
            context.client.setQueryData(TestimonialsQueryKey(params), (oldData: PaginationType<TestimonialType> | undefined) => {
                if (!oldData) return oldData;
                const oldUserDataIndex = oldData.data.findIndex((user) => user.id === id);
                if (oldUserDataIndex !== -1) {
                    const newData = [...oldData.data];
                    newData[oldUserDataIndex] = data;
                    return {
                        ...oldData,
                        data: newData,
                    };
                }
                return oldData;
            });
            context.client.setQueryData(TestimonialQueryKey(id), data);
            context.client.setQueryData(TestimonialQueryKey(id, true), data);
        },
    });
};

export const useTestimonialToggleStatusMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await toggleTestimonialStatusHandler(id);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Testimonial state toggled successfully");
            context.client.setQueryData(TestimonialsQueryKey(params), (oldData: PaginationType<TestimonialType> | undefined) => {
                if (!oldData) return oldData;
                const oldUserDataIndex = oldData.data.findIndex((user) => user.id === id);
                if (oldUserDataIndex !== -1) {
                    const newData = [...oldData.data];
                    newData[oldUserDataIndex] = data;
                    return {
                        ...oldData,
                        data: newData,
                    };
                }
                return oldData;
            });
            context.client.setQueryData(TestimonialQueryKey(id), data);
            context.client.setQueryData(TestimonialQueryKey(id, true), data);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};


export const useTestimonialDeleteMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteTestimonialHandler(id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Testimonial deleted successfully");
            context.client.invalidateQueries({ queryKey: TestimonialsQueryKey(params) });
            context.client.setQueryData(TestimonialQueryKey(id), undefined);
            context.client.setQueryData(TestimonialQueryKey(id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};