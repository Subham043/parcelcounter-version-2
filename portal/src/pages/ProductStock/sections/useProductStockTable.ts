// useProductStockTable.ts
import { useProductStocksQuery } from "@/utils/data/query/product_stock";
import { useParams } from "react-router";

export function useProductStockTable() {
    const { product_id } = useParams<{ product_id: string }>();
    const query = useProductStocksQuery(parseInt(product_id || "0"));
    return {
        ...query,
        product_id: parseInt(product_id || "0"),
    };
}
