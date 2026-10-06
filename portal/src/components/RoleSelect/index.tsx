import { AsyncPaginate } from "react-select-async-paginate";
import type { GroupBase, OptionsOrGroups } from "react-select";
import { useCallback } from "react";
import { useAuthStore } from "@/stores/auth.store";
import { getRolesHandler } from "@/utils/data/dal/role";

type OptionType = {
  value: string;
  label: string;
};

type Props = {
  value: string | undefined;
  onChange: (value: string | undefined) => void;
  isDisabled?: boolean;
  placeholder?: string;
  className?: string;
};

export default function RoleSelect({
  value,
  onChange,
  isDisabled = false,
  placeholder = "Select Role",
  className,
}: Props) {
  const authToken = useAuthStore((state) => state.authToken);

  const loadOptions = useCallback(
    async (
      search: string,
      _loadedOptions: OptionsOrGroups<OptionType, GroupBase<OptionType>>,
      additional: { page: number } | undefined,
    ) => {
      const params = new URLSearchParams({
        page: String(additional ? additional.page : 1),
        total: String(10),
        "filter[search]": search,
      });
      const response = await getRolesHandler(params);
      return {
        options: response.data.map((item) => ({
          value: item.name,
          label: item.name,
        })),
        hasMore:
          Math.ceil(response.meta.total / 10) >
          (additional ? additional.page : 1),
        additional: {
          page: additional ? additional.page + 1 : 1,
        },
      };
    },
    [],
  );

  return (
    <div className="relative z-20">
      <AsyncPaginate
        value={value ? { value: value, label: value } : null}
        isMulti={false}
        loadOptions={loadOptions}
        isDisabled={authToken === null || isDisabled}
        onChange={(value) => {
          onChange(value ? value.value : undefined);
        }}
        additional={{
          page: 1,
        }}
        debounceTimeout={500}
        isSearchable
        className={className}
        placeholder={placeholder}
        closeMenuOnSelect={true}
      />
    </div>
  );
}
