import type { GenericAbortSignal } from "axios";
import axios from "@/utils/axios";
import type { PaymentOptionType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";


export const togglePaymentOptionStatusHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: PaymentOptionType }>(api_routes.payment_option.toggle_status + `/${id}`, { signal });
    return response.data.data;
}


export const getPaymentOptionHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: PaymentOptionType }>(api_routes.payment_option.view + `/${id}`, { signal });
    return response.data.data;
}

export const getPaymentOptionsHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<PaymentOptionType>>(api_routes.payment_option.paginate, { params, signal });
    return response.data;
}


export const exportPaymentOptionsHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get(api_routes.payment_option.excel, { params, signal, responseType: "blob" });
    return new Blob([response.data], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
}