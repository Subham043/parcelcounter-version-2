import { useChargeExportMutation } from "@/utils/data/mutation/charge";
import { useCallback } from "react";
import ExcelExportButton from "@/components/ExcelExportButton";

function ChargeExcelBtn() {
  const chargeExportMutation = useChargeExportMutation();

  const onExport = useCallback(async () => {
    await chargeExportMutation.mutateAsync(undefined);
  }, [chargeExportMutation.mutateAsync]);

  return (
    <ExcelExportButton
      loading={chargeExportMutation.isPending}
      onExport={onExport}
    />
  );
}

export default ChargeExcelBtn;
