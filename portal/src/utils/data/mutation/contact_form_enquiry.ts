import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import { deleteContactFormEnquiryHandler } from "../dal/contact_form_enquiry";
import { ContactFormEnquiryQueryKey, ContactFormEnquiriesQueryKey } from "../query/contact_form_enquiry";
import { useSearchParams } from "react-router";


export const useContactFormEnquiryDeleteMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await deleteContactFormEnquiryHandler(id);
        },
        onSuccess: (_, __, ___, context) => {
            toastSuccess("Enquiry deleted successfully");
            context.client.invalidateQueries({ queryKey: ContactFormEnquiriesQueryKey(params) });
            context.client.setQueryData(ContactFormEnquiryQueryKey(id), undefined);
            context.client.setQueryData(ContactFormEnquiryQueryKey(id, true), undefined);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};