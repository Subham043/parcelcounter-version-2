import { useTaxExportMutation } from "@/utils/data/mutation/tax";
import { useCallback } from "react";
import ExcelExportButton from "@/components/ExcelExportButton";

function TaxExcelBtn() {
  const taxExportMutation = useTaxExportMutation();

  const onExport = useCallback(async () => {
    await taxExportMutation.mutateAsync(undefined);
  }, [taxExportMutation.mutateAsync]);

  return (
    <ExcelExportButton
      loading={taxExportMutation.isPending}
      onExport={onExport}
    />
  );
}

export default TaxExcelBtn;
