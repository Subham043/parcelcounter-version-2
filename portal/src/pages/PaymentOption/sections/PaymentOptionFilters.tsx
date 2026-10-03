import FilterClearBtn from "@/components/FilterClearBtn";
import SearchField from "@/components/SearchField";

function PaymentOptionFilters() {
  return (
    <div className="flex items-center gap-2">
      <SearchField />
      <FilterClearBtn />
    </div>
  );
}

export default PaymentOptionFilters;
