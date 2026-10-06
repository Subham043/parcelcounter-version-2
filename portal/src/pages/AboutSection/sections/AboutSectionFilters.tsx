import FilterClearBtn from "@/components/FilterClearBtn";
import SearchField from "@/components/SearchField";
import SelectActiveFilter from "@/components/SelectActiveFilter";

function AboutSectionFilters() {
  return (
    <div className="flex items-center gap-2">
      <SearchField />
      <SelectActiveFilter />
      <FilterClearBtn />
    </div>
  );
}

export default AboutSectionFilters;
