import { Search } from "lucide-react";
import {
  InputGroup,
  InputGroupAddon,
  InputGroupInput,
} from "@/components/ui/input-group";
import { useSearchQueryParam } from "@/hooks/useSearchQueryParam";
import { useCallback } from "react";

type Props = {
  placeholder?: string;
};

function SearchField({ placeholder = "Search..." }: Props) {
  const { search, setSearch } = useSearchQueryParam();
  const onSearchChange = useCallback(
    (e: React.ChangeEvent<HTMLInputElement>) => {
      setSearch(e.currentTarget.value);
    },
    [setSearch],
  );
  return (
    <InputGroup className="max-w-full flex-1">
      <InputGroupInput
        placeholder={placeholder}
        defaultValue={search}
        onChange={onSearchChange}
        autoFocus={search !== undefined && search.length > 0}
      />
      <InputGroupAddon>
        <Search />
      </InputGroupAddon>
    </InputGroup>
  );
}

export default SearchField;
