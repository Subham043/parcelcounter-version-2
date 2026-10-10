import SubCategorySelect from "@/components/SubCategorySelect";
import { useCustomQueryParam } from "@/hooks/useCustomQueryParam";
import { useCallback, useMemo } from "react";

type PropType = {
  key?: string;
  placeholder?: string;
};

const ProductSubCategoryFilter = (props: PropType) => {
  const { key = "filter[sub_category]", placeholder = "Sub-Category" } = props;
  const { paramValue, setQueryParams } = useCustomQueryParam(key);
  const { paramValue: subCategoryName } =
    useCustomQueryParam("sub_category_name");

  const value = useMemo(() => {
    if (subCategoryName && paramValue)
      return { label: subCategoryName, value: parseInt(paramValue) };
    return undefined;
  }, [paramValue, subCategoryName]);

  const onChange = useCallback(
    (value: { label: string; value: number } | undefined) => {
      if (value) {
        setQueryParams({
          [key]: value.value.toString(),
          sub_category_name: value.label,
        });
      } else {
        setQueryParams({
          [key]: undefined,
          sub_category_name: undefined,
        });
      }
    },
    [key, setQueryParams],
  );

  return (
    <div className="w-full max-w-52">
      <SubCategorySelect
        value={value}
        onChange={onChange}
        placeholder={placeholder}
      />
    </div>
  );
};

export default ProductSubCategoryFilter;
