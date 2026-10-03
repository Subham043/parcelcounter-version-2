import type { GenericAbortSignal } from "axios";
import axios from "@/utils/axios";
import type { ContactFormEnquiryType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";


export const deleteContactFormEnquiryHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: ContactFormEnquiryType }>(api_routes.contact_form_enquiry.delete + `/${id}`, { signal });
    return response.data.data;
}


export const getContactFormEnquiryHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: ContactFormEnquiryType }>(api_routes.contact_form_enquiry.view + `/${id}`, { signal });
    return response.data.data;
}

export const getContactFormEnquiriesHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<ContactFormEnquiryType>>(api_routes.contact_form_enquiry.paginate, { params, signal });
    return response.data;
}