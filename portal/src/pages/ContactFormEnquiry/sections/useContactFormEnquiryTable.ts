// useContactFormEnquiryTable.ts
import { useContactFormEnquiriesQuery } from "@/utils/data/query/contact_form_enquiry";

export function useContactFormEnquiryTable() {
    const query = useContactFormEnquiriesQuery();
    return {
        ...query,
    };
}
