// useLegalContentTable.ts
import { useLegalContentsQuery } from "@/utils/data/query/legal_content";

export function useLegalContentTable() {
    const query = useLegalContentsQuery();
    return {
        ...query,
    };
}
