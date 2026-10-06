// useAboutSectionTable.ts
import { useAboutSectionsQuery } from "@/utils/data/query/about_section";

export function useAboutSectionTable() {
    const query = useAboutSectionsQuery();
    return {
        ...query,
    };
}
