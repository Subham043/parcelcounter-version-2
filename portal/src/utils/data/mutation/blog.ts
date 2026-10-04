import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { BlogFormValuesType } from "../schema/blog";
import { createBlogHandler, deleteBlogHandler, exportBlogsHandler, toggleBlogStatusHandler, updateBlogHandler } from "../dal/blog";
import type { PaginationType, BlogType } from "@/utils/types";
import { BlogQueryKey, BlogsQueryKey } from "../query/blog";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";
import { downloadExcel } from "@/utils/helper";

export const useBlogCreateMutation = () => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: BlogFormValuesType) => {
            return await createBlogHandler(val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Blog created successfully");
            // context.client.invalidateQueries({ queryKey: BlogsQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(BlogsQueryKey(params), (oldData: PaginationType<BlogType> | undefined) => {
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
                context.client.invalidateQueries({ queryKey: BlogsQueryKey(params) });
            }
        },
    });
};

export const useBlogUpdateMutation = (id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: BlogFormValuesType) => {
            return await updateBlogHandler(id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Blog updated successfully");
            context.client.setQueryData(BlogsQueryKey(params), (oldData: PaginationType<BlogType> | undefined) => {
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
            context.client.setQueryData(BlogQueryKey(id), data);
            context.client.setQueryData(BlogQueryKey(id, true), data);
        },
    });
};

export const useBlogToggleStatusMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await toggleBlogStatusHandler(id);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Blog state toggled successfully");
            context.client.setQueryData(BlogsQueryKey(params), (oldData: PaginationType<BlogType> | undefined) => {
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
            context.client.setQueryData(BlogQueryKey(id), data);
            context.client.setQueryData(BlogQueryKey(id, true), data);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};


export const useBlogDeleteMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteBlogHandler(id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Blog deleted successfully");
            context.client.invalidateQueries({ queryKey: BlogsQueryKey(params) });
            context.client.setQueryData(BlogQueryKey(id), undefined);
            context.client.setQueryData(BlogQueryKey(id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};

export const useBlogExportMutation = () => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await exportBlogsHandler(params);
        },
        onSuccess: (data) => {
            toastSuccess("Blog exported successfully");
            downloadExcel(data, `blog_${new Date().toISOString().slice(0, 10)}.xlsx`);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};