// useBlogTable.ts
import { useBlogsQuery } from "@/utils/data/query/blog";

export function useBlogTable() {
    const query = useBlogsQuery();
    return {
        ...query,
    };
}
