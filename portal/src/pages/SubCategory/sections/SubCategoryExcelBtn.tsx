import { useSubCategoryExportMutation } from "@/utils/data/mutation/sub_category";
import { useCallback } from "react";
import ExcelExportButton from "@/components/ExcelExportButton";

function SubCategoryExcelBtn() {
  const subCategoryExportMutation = useSubCategoryExportMutation();

  const onExport = useCallback(async () => {
    await subCategoryExportMutation.mutateAsync(undefined);
  }, [subCategoryExportMutation.mutateAsync]);

  return (
    <ExcelExportButton
      loading={subCategoryExportMutation.isPending}
      onExport={onExport}
    />
  );
}

export default SubCategoryExcelBtn;
