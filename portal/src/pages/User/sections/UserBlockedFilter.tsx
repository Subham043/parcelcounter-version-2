import { useCustomQueryParam } from "@/hooks/useCustomQueryParam";
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";

type PropType = {
  key?: string;
  placeholder?: string;
};

const isActiveItems = [
  { label: "Yes", value: "no" },
  { label: "No", value: "yes" },
];

const UserBlockedFilter = (props: PropType) => {
  const { key = "filter[is_blocked]", placeholder = "Is Active" } = props;
  const { paramValue, setParamValue } = useCustomQueryParam(key);
  return (
    <Select
      items={isActiveItems}
      value={paramValue}
      onValueChange={(value) => setParamValue(value)}
    >
      <SelectTrigger className="w-full max-w-36">
        <SelectValue placeholder={placeholder} />
      </SelectTrigger>
      <SelectContent>
        <SelectGroup>
          <SelectLabel>{placeholder}</SelectLabel>
          {isActiveItems.map((item) => (
            <SelectItem key={item.value} value={item.value}>
              {item.label}
            </SelectItem>
          ))}
        </SelectGroup>
      </SelectContent>
    </Select>
  );
};

export default UserBlockedFilter;
