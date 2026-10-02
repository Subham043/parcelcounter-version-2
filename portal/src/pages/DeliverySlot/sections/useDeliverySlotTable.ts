// useChargeTable.ts
import { useDeliverySlotsQuery } from "@/utils/data/query/delivery_slot";

export function useDeliverySlotTable() {
    const query = useDeliverySlotsQuery();
    return {
        ...query,
    };
}
