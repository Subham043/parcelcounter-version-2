import FilterClearBtn from "@/components/FilterClearBtn";
import SearchField from "@/components/SearchField";
import SelectActiveFilter from "@/components/SelectActiveFilter";
import TaxInterStateFilter from "./TaxInterStateFilter";

function TaxFilters() {
  return (
    <div className="flex items-center gap-2">
      <SearchField />
      <TaxInterStateFilter />
      <SelectActiveFilter />
      <FilterClearBtn />
    </div>
  );
}

export default TaxFilters;
