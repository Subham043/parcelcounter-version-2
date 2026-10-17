// useProductVideoTable.ts
import { useProductVideosQuery } from "@/utils/data/query/product_video";
import { useParams } from "react-router";

export function useProductVideoTable() {
    const { product_id } = useParams<{ product_id: string }>();
    const query = useProductVideosQuery(parseInt(product_id || "0"));
    return {
        ...query,
        product_id: parseInt(product_id || "0"),
    };
}
