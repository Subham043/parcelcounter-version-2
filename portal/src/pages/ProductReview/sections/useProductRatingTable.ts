// useProductReviewTable.ts
import { useProductReviewsQuery } from "@/utils/data/query/product_review";
import { useParams } from "react-router";

export function useProductReviewTable() {
    const { product_id } = useParams<{ product_id: string }>();
    const query = useProductReviewsQuery(parseInt(product_id || "0"));
    return {
        ...query,
        product_id: parseInt(product_id || "0"),
    };
}
