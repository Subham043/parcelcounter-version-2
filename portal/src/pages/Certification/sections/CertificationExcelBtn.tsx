import { useCertificationExportMutation } from "@/utils/data/mutation/certification";
import { useCallback } from "react";
import ExcelExportButton from "@/components/ExcelExportButton";

function CertificationExcelBtn() {
  const certificationExportMutation = useCertificationExportMutation();

  const onExport = useCallback(async () => {
    await certificationExportMutation.mutateAsync(undefined);
  }, [certificationExportMutation.mutateAsync]);

  return (
    <ExcelExportButton
      loading={certificationExportMutation.isPending}
      onExport={onExport}
    />
  );
}

export default CertificationExcelBtn;
