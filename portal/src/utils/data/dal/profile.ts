import axios from "@/utils/axios";
import publicAxios from "axios";
import { api_routes } from "../../routes/api_routes";
import type { ProfileType } from "../../types";
import type { GenericAbortSignal } from "axios";
import { axiosConfig } from "@/utils/constants/axios";
import type { ProfileUpdateFormValuesType } from "@/utils/data/schema/profile";
import type { PasswordUpdateFormValuesType } from "@/utils/data/schema/profile";

export const updateProfileHandler = async (val: ProfileUpdateFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ profile: ProfileType }>(api_routes.account.update, val, { signal });
    return response.data.profile;
}

export const changePasswordHandler = async (val: PasswordUpdateFormValuesType, signal?: GenericAbortSignal | undefined) => {
    await axios.post(api_routes.account.update_password, val, { signal });
}

export const getProfileHandler = async (signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ profile: ProfileType, token: string }>(api_routes.account.get, { signal });
    return response.data;
}

export const logoutHandler = async (signal?: GenericAbortSignal | undefined) => {
    await axios.post(api_routes.account.logout, {}, { signal });
}

export const refreshTokenHandler = async (signal?: GenericAbortSignal | undefined) => {
    const response = await publicAxios.post<{ token: string }>(api_routes.account.refresh, {}, { ...axiosConfig, signal });
    return response.data.token;
}