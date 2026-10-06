import { useCustomQueryParam } from "@/hooks/useCustomQueryParam";
import RoleSelect from "@/components/RoleSelect";

type PropType = {
  key?: string;
  placeholder?: string;
};

const UserRoleFilter = (props: PropType) => {
  const { key = "filter[role]", placeholder = "Role" } = props;
  const { paramValue, setParamValue } = useCustomQueryParam(key);
  return (
    <div className="w-full max-w-52">
      <RoleSelect
        value={paramValue}
        onChange={(value) => setParamValue(value)}
        placeholder={placeholder}
      />
    </div>
  );
};

export default UserRoleFilter;
