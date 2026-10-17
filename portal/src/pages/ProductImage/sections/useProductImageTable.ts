// useProductImageTable.ts
import { useProductImagesQuery } from "@/utils/data/query/product_image";
import { useParams } from "react-router";

export function useProductImageTable() {
    const { product_id } = useParams<{ product_id: string }>();
    const query = useProductImagesQuery(parseInt(product_id || "0"));
    return {
        ...query,
        product_id: parseInt(product_id || "0"),
    };
}
