// useProductSpecificationTable.ts
import { useProductSpecificationsQuery } from "@/utils/data/query/product_specification";
import { useParams } from "react-router";

export function useProductSpecificationTable() {
    const { product_id } = useParams<{ product_id: string }>();
    const query = useProductSpecificationsQuery(parseInt(product_id || "0"));
    return {
        ...query,
        product_id: parseInt(product_id || "0"),
    };
}
