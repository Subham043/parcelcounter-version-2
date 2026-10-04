import FilterClearBtn from "@/components/FilterClearBtn";
import SearchField from "@/components/SearchField";
import SelectActiveFilter from "@/components/SelectActiveFilter";
import BlogPopularFilter from "./BlogPopularFilter";

function BlogFilters() {
  return (
    <div className="flex items-center gap-2">
      <SearchField />
      <BlogPopularFilter />
      <SelectActiveFilter />
      <FilterClearBtn />
    </div>
  );
}

export default BlogFilters;
