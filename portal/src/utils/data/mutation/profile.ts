import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import { useAuthStore } from "@/stores/auth.store";
import { ProfileQueryKey } from "../query/profile";
import type { ProfileUpdateFormValuesType } from "@/utils/data/schema/profile";
import type { PasswordUpdateFormValuesType } from "@/utils/data/schema/profile";
import { changePasswordHandler, updateProfileHandler } from "../dal/profile";


export const useProfileUpdateMutation = () => {
    const { toastSuccess } = useToast();
    const setAuthUser = useAuthStore((state) => state.setAuthUser)
    return useMutation({
        mutationFn: async (val: ProfileUpdateFormValuesType) => {
            return await updateProfileHandler(val);
        },
        onSuccess: (data, _, __, context) => {
            toastSuccess("Profile updated successfully");
            context.client.setQueryData(ProfileQueryKey(), data);
            context.client.setQueryData(ProfileQueryKey(true), data);
            setAuthUser(data)
        },
    });
};

export const usePasswordUpdateMutation = () => {
    const { toastSuccess } = useToast();
    return useMutation({
        mutationFn: async (val: PasswordUpdateFormValuesType) => {
            await changePasswordHandler(val);
        },
        onSuccess: () => {
            toastSuccess("Password updated successfully");
        },
    });
};

export const useLogoutMutation = () => {
    const logout = useAuthStore((state) => state.logout)
    const { toastSuccess, toastError } = useToast();
    return useMutation({
        mutationFn: async () => {
            await logout();
        },
        onSuccess: () => {
            toastSuccess("Logged out successfully");
        },
        onError: () => {
            toastError("Failed to log out");
        },
    });
};