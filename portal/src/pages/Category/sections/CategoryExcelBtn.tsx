import { useCategoryExportMutation } from "@/utils/data/mutation/category";
import { useCallback } from "react";
import ExcelExportButton from "@/components/ExcelExportButton";

function CategoryExcelBtn() {
  const categoryExportMutation = useCategoryExportMutation();

  const onExport = useCallback(async () => {
    await categoryExportMutation.mutateAsync(undefined);
  }, [categoryExportMutation.mutateAsync]);

  return (
    <ExcelExportButton
      loading={categoryExportMutation.isPending}
      onExport={onExport}
    />
  );
}

export default CategoryExcelBtn;
