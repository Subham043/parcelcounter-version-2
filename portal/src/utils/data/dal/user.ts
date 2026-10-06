import type { GenericAbortSignal } from "axios";
import type { UserFormValuesType } from "../schema/user";
import axios from "@/utils/axios";
import type { UserType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";


export const createUserHandler = async (val: UserFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: UserType }>(api_routes.user.create, { ...val, is_blocked: val.is_blocked ? 1 : 0 }, { signal });
    return response.data.data;
}


export const updateUserHandler = async (id: number, val: UserFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: UserType }>(api_routes.user.update + `/${id}`, { ...val, is_blocked: val.is_blocked ? 1 : 0 }, { signal });
    return response.data.data;
}


export const deleteUserHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: UserType }>(api_routes.user.delete + `/${id}`, { signal });
    return response.data.data;
}


export const toggleUserStatusHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: UserType }>(api_routes.user.toggle_status + `/${id}`, { signal });
    return response.data.data;
}

export const toggleUserVerificationHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: UserType }>(api_routes.user.toggle_verification + `/${id}`, { signal });
    return response.data.data;
}


export const getUserHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: UserType }>(api_routes.user.view + `/${id}`, { signal });
    return response.data.data;
}

export const getUsersHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<UserType>>(api_routes.user.paginate, { params, signal });
    return response.data;
}


export const exportUsersHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get(api_routes.user.excel, { params, signal, responseType: "blob" });
    return new Blob([response.data], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
}