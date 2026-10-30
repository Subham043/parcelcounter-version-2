// useCertificationTable.ts
import { useCertificationsQuery } from "@/utils/data/query/certification";

export function useCertificationTable() {
    const query = useCertificationsQuery();
    return {
        ...query,
    };
}
