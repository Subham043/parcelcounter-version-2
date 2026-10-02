// useChargeTable.ts
import { useChargesQuery } from "@/utils/data/query/charge";

export function useChargeTable() {
    const query = useChargesQuery();
    return {
        ...query,
    };
}
