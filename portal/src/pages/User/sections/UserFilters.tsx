import FilterClearBtn from "@/components/FilterClearBtn";
import SearchField from "@/components/SearchField";
import UserBlockedFilter from "./UserBlockedFilter";
import UserVerifiedFilter from "./UserVerifiedFilter";
import UserRoleFilter from "./UserRoleFilter";

function UserFilters() {
  return (
    <div className="flex items-center gap-2">
      <SearchField />
      <UserRoleFilter />
      <UserVerifiedFilter />
      <UserBlockedFilter />
      <FilterClearBtn />
    </div>
  );
}

export default UserFilters;
