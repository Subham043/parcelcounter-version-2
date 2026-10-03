// useBannerTable.ts
import { useBannersQuery } from "@/utils/data/query/banner";

export function useBannerTable() {
    const query = useBannersQuery();
    return {
        ...query,
    };
}
