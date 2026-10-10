// useProductTable.ts
import { useProductsQuery } from "@/utils/data/query/product";

export function useProductTable() {
    const query = useProductsQuery({ includeCategory: true, includeSubCategory: true });
    return {
        ...query,
    };
}
