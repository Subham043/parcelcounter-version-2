import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import type { UserFormValuesType } from "../schema/user";
import { createUserHandler, deleteUserHandler, exportUsersHandler, toggleUserStatusHandler, toggleUserVerificationHandler, updateUserHandler } from "../dal/user";
import type { PaginationType, UserType } from "@/utils/types";
import { UserQueryKey, UsersQueryKey } from "../query/user";
import { useSearchParams } from "react-router";
import { usePaginationQueryParam } from "@/hooks/usePaginationQueryParam";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";
import { downloadExcel } from "@/utils/helper";

export const useUserCreateMutation = () => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();
    const { page, total } = usePaginationQueryParam();
    const { search } = useSearchQueryParam();

    return useMutation({
        mutationFn: async (val: UserFormValuesType) => {
            return await createUserHandler(val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("User created successfully");
            // context.client.invalidateQueries({ queryKey: UsersQueryKey(params) });
            if (page === 1 && !search) {
                context.client.setQueryData(UsersQueryKey(params), (oldData: PaginationType<UserType> | undefined) => {
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
                context.client.invalidateQueries({ queryKey: UsersQueryKey(params) });
            }
        },
    });
};

export const useUserUpdateMutation = (id: number) => {
    const { toastSuccess } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async (val: UserFormValuesType) => {
            return await updateUserHandler(id, val);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("User updated successfully");
            context.client.setQueryData(UsersQueryKey(params), (oldData: PaginationType<UserType> | undefined) => {
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
            context.client.setQueryData(UserQueryKey(id), data);
            context.client.setQueryData(UserQueryKey(id, true), data);
        },
    });
};

export const useUserToggleStatusMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await toggleUserStatusHandler(id);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("User state toggled successfully");
            context.client.setQueryData(UsersQueryKey(params), (oldData: PaginationType<UserType> | undefined) => {
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
            context.client.setQueryData(UserQueryKey(id), data);
            context.client.setQueryData(UserQueryKey(id, true), data);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};

export const useUserToggleVerificationMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await toggleUserVerificationHandler(id);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("User verification toggled successfully");
            context.client.setQueryData(UsersQueryKey(params), (oldData: PaginationType<UserType> | undefined) => {
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
            context.client.setQueryData(UserQueryKey(id), data);
            context.client.setQueryData(UserQueryKey(id, true), data);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};


export const useUserDeleteMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteUserHandler(id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("User deleted successfully");
            context.client.invalidateQueries({ queryKey: UsersQueryKey(params) });
            context.client.setQueryData(UserQueryKey(id), undefined);
            context.client.setQueryData(UserQueryKey(id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};

export const useUserExportMutation = () => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await exportUsersHandler(params);
        },
        onSuccess: (data) => {
            toastSuccess("Users exported successfully");
            downloadExcel(data, `users_${new Date().toISOString().slice(0, 10)}.xlsx`);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};