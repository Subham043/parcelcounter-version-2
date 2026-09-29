import { env } from "@/configs/env";
import type { AxiosRequestConfig } from "axios";

export const axiosConfig: AxiosRequestConfig = {
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
    // Authorization: undefined,
  },
  baseURL: env.API_ENDPOINT,
  withCredentials: true,
};