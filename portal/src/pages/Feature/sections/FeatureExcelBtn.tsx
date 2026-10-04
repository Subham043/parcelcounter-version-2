import { useFeatureExportMutation } from "@/utils/data/mutation/feature";
import { useCallback } from "react";
import ExcelExportButton from "@/components/ExcelExportButton";

function FeatureExcelBtn() {
  const featureExportMutation = useFeatureExportMutation();

  const onExport = useCallback(async () => {
    await featureExportMutation.mutateAsync(undefined);
  }, [featureExportMutation.mutateAsync]);

  return (
    <ExcelExportButton
      loading={featureExportMutation.isPending}
      onExport={onExport}
    />
  );
}

export default FeatureExcelBtn;
