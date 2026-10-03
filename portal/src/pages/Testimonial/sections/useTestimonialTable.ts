// useTestimonialTable.ts
import { useTestimonialsQuery } from "@/utils/data/query/testimonial";

export function useTestimonialTable() {
    const query = useTestimonialsQuery();
    return {
        ...query,
    };
}
