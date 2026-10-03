import FilterClearBtn from "@/components/FilterClearBtn";
import SearchField from "@/components/SearchField";
import SelectActiveFilter from "@/components/SelectActiveFilter";

function BannerFilters() {
  return (
    <div className="flex items-center gap-2">
      <SearchField />
      <SelectActiveFilter />
      <FilterClearBtn />
    </div>
  );
}

export default BannerFilters;
