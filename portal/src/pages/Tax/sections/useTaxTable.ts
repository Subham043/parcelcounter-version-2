// TaxTable.ts
import { useTaxesQuery } from "@/utils/data/query/tax";

export function useTaxTable() {
    const query = useTaxesQuery();
    return {
        ...query,
    };
}
