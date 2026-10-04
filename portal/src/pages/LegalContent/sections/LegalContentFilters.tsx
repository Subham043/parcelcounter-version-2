import FilterClearBtn from "@/components/FilterClearBtn";
import SearchField from "@/components/SearchField";
import SelectActiveFilter from "@/components/SelectActiveFilter";

function LegalContentFilters() {
  return (
    <div className="flex items-center gap-2">
      <SearchField />
      <SelectActiveFilter />
      <FilterClearBtn />
    </div>
  );
}

export default LegalContentFilters;
