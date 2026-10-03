// useContactFormEnquiryTable.ts
import { usePaymentOptionsQuery } from "@/utils/data/query/payment_option";

export function usePaymentOptionTable() {
    const query = usePaymentOptionsQuery();
    return {
        ...query,
    };
}
