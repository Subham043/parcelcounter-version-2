// hooks/useContactFormEnquiryForm.ts
import { useCallback } from "react";
import { useContactFormEnquiryModalStore } from "../store/contact-form-enquiry-modal.store";
import { useContactFormEnquiryQuery } from "@/utils/data/query/contact_form_enquiry";

export function useContactFormEnquiryForm() {

    const modal = useContactFormEnquiryModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useContactFormEnquiryQuery(
        modal.show ? modal.id : 0,
        modal.show,
        false
    );

    const handleClose = useCallback(() => {
        useContactFormEnquiryModalStore.getState().handleModalClose();
    }, []);

    return {
        modal,
        data,
        isLoading: isLoading || isFetching || isRefetching,
        handleClose,
    };
}
