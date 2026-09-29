import axios from "@/utils/axios";
import { api_routes } from "../../routes/api_routes";
import type { AuthType } from "../../types";
import type { GenericAbortSignal } from "axios";
import type { EmailLoginFormValuesType, PhoneForgotPasswordFormValuesType, PhonePasswordLoginFormValuesType, RegisterFormValuesType } from "@/utils/data/schema/auth";
import type { EmailForgotPasswordFormValuesType } from "@/utils/data/schema/auth";
import type { ResetPasswordFormValuesType } from "@/utils/data/schema/auth";

export const emailLoginHandler = async (val: EmailLoginFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ user: AuthType, token: string }>(
        api_routes.auth.login_with_email_password,
        val,
        { signal }
    );
    return response.data;
}

export const phonePasswordLoginHandler = async (val: PhonePasswordLoginFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ user: AuthType, token: string }>(
        api_routes.auth.login_with_phone_password,
        val,
        { signal }
    );
    return response.data;
}

export const emailForgotPasswordHandler = async (val: EmailForgotPasswordFormValuesType, signal?: GenericAbortSignal | undefined) => {
    await axios.post(
        api_routes.auth.forgot_password_email,
        val,
        { signal }
    );
}

export const phoneForgotPasswordHandler = async (val: PhoneForgotPasswordFormValuesType, signal?: GenericAbortSignal | undefined) => {
    await axios.post(
        api_routes.auth.forgot_password_phone,
        val,
        { signal }
    );
}

export const resetPasswordHandler = async (token: string, val: ResetPasswordFormValuesType, signal?: GenericAbortSignal | undefined) => {
    await axios.post(
        `${api_routes.auth.reset_password}/${token}`,
        val,
        { signal }
    );
}

export const registerHandler = async (val: RegisterFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ user: AuthType, token: string }>(
        api_routes.auth.register,
        val,
        { signal }
    );
    return response.data;
}
