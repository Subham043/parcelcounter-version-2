// useProductPriceTable.ts
import { useProductPricesQuery } from "@/utils/data/query/product_price";
import { useParams } from "react-router";

export function useProductPriceTable() {
    const { product_id } = useParams<{ product_id: string }>();
    const query = useProductPricesQuery(parseInt(product_id || "0"));
    return {
        ...query,
        product_id: parseInt(product_id || "0"),
    };
}
