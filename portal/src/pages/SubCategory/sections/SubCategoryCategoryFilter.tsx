import CategorySelect from "@/components/CategorySelect";
import { useCustomQueryParam } from "@/hooks/useCustomQueryParam";
import { useCallback, useMemo } from "react";

type PropType = {
  key?: string;
  placeholder?: string;
};

const SubCategoryCategoryFilter = (props: PropType) => {
  const { key = "filter[category]", placeholder = "Category" } = props;
  const { paramValue, setQueryParams } = useCustomQueryParam(key);
  const { paramValue: categoryName } = useCustomQueryParam("category_name");

  const value = useMemo(() => {
    if (categoryName && paramValue)
      return { label: categoryName, value: parseInt(paramValue) };
    return undefined;
  }, [paramValue, categoryName]);

  const onChange = useCallback(
    (value: { label: string; value: number } | undefined) => {
      if (value) {
        setQueryParams({
          [key]: value.value.toString(),
          category_name: value.label,
        });
      } else {
        setQueryParams({
          [key]: undefined,
          category_name: undefined,
        });
      }
    },
    [key, setQueryParams],
  );

  return (
    <div className="w-full max-w-52">
      <CategorySelect
        value={value}
        onChange={onChange}
        placeholder={placeholder}
      />
    </div>
  );
};

export default SubCategoryCategoryFilter;
