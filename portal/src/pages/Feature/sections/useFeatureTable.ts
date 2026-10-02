// useFeatureTable.ts
import { useFeaturesQuery } from "@/utils/data/query/feature";

export function useFeatureTable() {
    const query = useFeaturesQuery();
    return {
        ...query,
    };
}
