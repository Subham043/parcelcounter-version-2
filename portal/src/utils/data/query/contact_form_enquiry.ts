import { useAuthStore } from "@/stores/auth.store";
import type { PaginationType, ContactFormEnquiryType } from "@/utils/types";
import { useQuery, type UseQueryResult } from "@tanstack/react-query";
import { getContactFormEnquiryHandler, getContactFormEnquiriesHandler } from "../dal/contact_form_enquiry";
import { useSearchParams } from "react-router";


export const ContactFormEnquiryQueryKey = (id: number, isEdit: boolean = false) => {
    if (isEdit) {
        return ["contact_form_enquiry", id, "edit"]
    }
    return ["contact_form_enquiry", id, "view"]
};

export const ContactFormEnquiriesQueryKey = (params: URLSearchParams) => {
    return ["contact_form_enquiries", params.toString()]
};

export const ContactFormEnquiryQueryFn = async ({ id, signal }: { id: number, signal?: AbortSignal }) => {
    return await getContactFormEnquiryHandler(id, signal);
}

export const ContactFormEnquiriesQueryFn = async ({ params, signal }: { params: URLSearchParams, signal?: AbortSignal }) => {
    return await getContactFormEnquiriesHandler(params, signal);
}

/*
  Sales Quotation Query Hook Function: This hook is used to fetch information of the logged in user
*/
export const useContactFormEnquiryQuery: (id: number, enabled: boolean, isEdit?: boolean) => UseQueryResult<
    ContactFormEnquiryType | undefined,
    unknown
> = (id, enabled, isEdit = false) => {
    const authToken = useAuthStore((state) => state.authToken)

    return useQuery({
        queryKey: ContactFormEnquiryQueryKey(id, isEdit),
        queryFn: ({ signal }) => ContactFormEnquiryQueryFn({ id, signal }),
        enabled: authToken !== null && enabled,
    });
};

/*
  Sales Quotations Query Hook Function: This hook is used to fetch information of all the users
*/
export const useContactFormEnquiriesQuery: () => UseQueryResult<
    PaginationType<ContactFormEnquiryType> | undefined,
    unknown
> = () => {
    const authToken = useAuthStore((state) => state.authToken)
    const [params] = useSearchParams();

    return useQuery({
        queryKey: ContactFormEnquiriesQueryKey(params),
        queryFn: ({ signal }) => ContactFormEnquiriesQueryFn({ params, signal }),
        enabled: authToken !== null,
    });
};