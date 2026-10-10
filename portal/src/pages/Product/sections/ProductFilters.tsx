import FilterClearBtn from "@/components/FilterClearBtn";
import SearchField from "@/components/SearchField";
import SelectActiveFilter from "@/components/SelectActiveFilter";
import ProductCategoryFilter from "./ProductCategoryFilter";
import ProductSubCategoryFilter from "./ProductSubCategoryFilter";

function ProductFilters() {
  return (
    <div className="flex items-center gap-2">
      <SearchField />
      <ProductCategoryFilter />
      <ProductSubCategoryFilter />
      <SelectActiveFilter />
      <FilterClearBtn />
    </div>
  );
}

export default ProductFilters;
