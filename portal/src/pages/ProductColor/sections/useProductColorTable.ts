// useProductColorTable.ts
import { useProductColorsQuery } from "@/utils/data/query/product_color";
import { useParams } from "react-router";

export function useProductColorTable() {
    const { product_id } = useParams<{ product_id: string }>();
    const query = useProductColorsQuery(parseInt(product_id || "0"));
    return {
        ...query,
        product_id: parseInt(product_id || "0"),
    };
}
