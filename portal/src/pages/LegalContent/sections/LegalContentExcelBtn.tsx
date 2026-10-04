import { useLegalContentExportMutation } from "@/utils/data/mutation/legal_content";
import { useCallback } from "react";
import ExcelExportButton from "@/components/ExcelExportButton";

function LegalContentExcelBtn() {
  const legalContentExportMutation = useLegalContentExportMutation();

  const onExport = useCallback(async () => {
    await legalContentExportMutation.mutateAsync(undefined);
  }, [legalContentExportMutation.mutateAsync]);

  return (
    <ExcelExportButton
      loading={legalContentExportMutation.isPending}
      onExport={onExport}
    />
  );
}

export default LegalContentExcelBtn;
