import FilterClearBtn from "@/components/FilterClearBtn";
import SearchField from "@/components/SearchField";

function ProductRatingFilters() {
  return (
    <div className="flex items-center gap-2">
      <SearchField />
      <FilterClearBtn />
    </div>
  );
}

export default ProductRatingFilters;
