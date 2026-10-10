import { AsyncPaginate } from "react-select-async-paginate";
import type { GroupBase, OptionsOrGroups } from "react-select";
import { useCallback } from "react";
import { useAuthStore } from "@/stores/auth.store";
import { getSubCategoriesHandler } from "@/utils/data/dal/sub_category";

type OptionType = {
  value: number;
  label: string;
};

type Props = {
  value: OptionType | undefined;
  onChange: (value: OptionType | undefined) => void;
  isDisabled?: boolean;
  placeholder?: string;
  className?: string;
};

export default function SubCategorySelect({
  value,
  onChange,
  isDisabled = false,
  placeholder = "Select Sub-Category",
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
      const response = await getSubCategoriesHandler(params, undefined, {
        isSelect: true,
      });
      return {
        options: response.data.map((item) => ({
          value: item.id,
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
    <div className="relative z-20 flex-1">
      <AsyncPaginate
        value={value ? value : null}
        isMulti={false}
        loadOptions={loadOptions}
        isDisabled={authToken === null || isDisabled}
        onChange={(value) => {
          onChange(value ? value : undefined);
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
