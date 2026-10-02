import FilterClearBtn from "@/components/FilterClearBtn";
import SearchField from "@/components/SearchField";
import SelectActiveFilter from "@/components/SelectActiveFilter";
import DeliverySlotCODFilter from "./DeliverySlotCODFilter";

function DeliverySlotFilters() {
  return (
    <div className="flex items-center gap-2">
      <SearchField />
      <DeliverySlotCODFilter />
      <SelectActiveFilter />
      <FilterClearBtn />
    </div>
  );
}

export default DeliverySlotFilters;
