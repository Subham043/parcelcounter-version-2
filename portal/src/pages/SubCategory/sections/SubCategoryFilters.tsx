import FilterClearBtn from "@/components/FilterClearBtn";
import SearchField from "@/components/SearchField";
import SelectActiveFilter from "@/components/SelectActiveFilter";
import SubCategoryCategoryFilter from "./SubCategoryCategoryFilter";

function SubCategoryFilters() {
  return (
    <div className="flex items-center gap-2">
      <SearchField />
      <SubCategoryCategoryFilter />
      <SelectActiveFilter />
      <FilterClearBtn />
    </div>
  );
}

export default SubCategoryFilters;
