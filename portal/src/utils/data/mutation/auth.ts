import { useToast } from "@/hooks/useToast";
import { useAuthStore } from "@/stores/auth.store";
import { useMutation } from "@tanstack/react-query";
import { emailLoginHandler, emailForgotPasswordHandler, phonePasswordLoginHandler, registerHandler, resetPasswordHandler, phoneForgotPasswordHandler } from "../dal/auth";
import type { EmailLoginFormValuesType, PhoneForgotPasswordFormValuesType, PhonePasswordLoginFormValuesType, RegisterFormValuesType } from "@/utils/data/schema/auth";
import type { EmailForgotPasswordFormValuesType } from "@/utils/data/schema/auth";
import type { ResetPasswordFormValuesType } from "@/utils/data/schema/auth";
import { ProfileQueryKey } from "../query/profile";


export const useEmailLoginMutation = () => {
    const setAuth = useAuthStore((state) => state.setAuth)
    const { toastSuccess } = useToast();
    return useMutation({
        mutationFn: async (val: EmailLoginFormValuesType) => {
            return await emailLoginHandler(val);
        },
        // 💡 response of the mutation is passed to onSuccess
        onSuccess: (data, _, __, context) => {
            const { token, user } = data;
            setAuth(user, token);
            context.client.setQueryData(ProfileQueryKey(), user);
            toastSuccess("Logged in successfully");
        },
    });
};

export const usePhonePasswordLoginMutation = () => {
    const setAuth = useAuthStore((state) => state.setAuth)
    const { toastSuccess } = useToast();
    return useMutation({
        mutationFn: async (val: PhonePasswordLoginFormValuesType) => {
            return await phonePasswordLoginHandler(val);
        },
        // 💡 response of the mutation is passed to onSuccess
        onSuccess: (data, _, __, context) => {
            const { token, user } = data;
            setAuth(user, token);
            context.client.setQueryData(ProfileQueryKey(), user);
            toastSuccess("Logged in successfully");
        },
    });
};

export const useEmailForgotPasswordMutation = () => {
    const { toastInfo } = useToast();
    return useMutation({
        mutationFn: async (val: EmailForgotPasswordFormValuesType) => {
            await emailForgotPasswordHandler(val);
        },
        onSuccess: () => {
            toastInfo("We have sent an otp to your email to reset your password.");
        },
    });
};

export const usePhoneForgotPasswordMutation = () => {
    const { toastInfo } = useToast();
    return useMutation({
        mutationFn: async (val: PhoneForgotPasswordFormValuesType) => {
            await phoneForgotPasswordHandler(val);
        },
        onSuccess: () => {
            toastInfo("We have sent an otp to your phone number to reset your password.");
        },
    });
};

export const useResetPasswordMutation = () => {
    const { toastSuccess } = useToast();
    return useMutation({
        mutationFn: async (val: ResetPasswordFormValuesType & { token: string }) => {
            const { token, ...data } = val;
            await resetPasswordHandler(token, data);
        },
        onSuccess: () => {
            toastSuccess("Password updated successfully.");
        },
    });
};

export const useRegisterMutation = () => {
    const setAuth = useAuthStore((state) => state.setAuth)
    const { toastSuccess } = useToast();
    return useMutation({
        mutationFn: async (val: RegisterFormValuesType) => {
            return await registerHandler(val);
        },
        onSuccess: (data, _, __, context) => {
            const { token, user } = data;
            setAuth(user, token);
            context.client.setQueryData(ProfileQueryKey(), user);
            toastSuccess("Account created successfully.");
        },
    });
};