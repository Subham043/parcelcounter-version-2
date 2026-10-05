// useSubCategoryTable.ts
import { useSubCategoriesQuery } from "@/utils/data/query/sub_category";

export function useSubCategoryTable() {
    const query = useSubCategoriesQuery(true, false);
    return {
        ...query,
    };
}
