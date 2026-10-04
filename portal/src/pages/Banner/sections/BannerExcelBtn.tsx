import { useBannerExportMutation } from "@/utils/data/mutation/banner";
import { useCallback } from "react";
import ExcelExportButton from "@/components/ExcelExportButton";

function BannerExcelBtn() {
  const bannerExportMutation = useBannerExportMutation();

  const onExport = useCallback(async () => {
    await bannerExportMutation.mutateAsync(undefined);
  }, [bannerExportMutation.mutateAsync]);

  return (
    <ExcelExportButton
      loading={bannerExportMutation.isPending}
      onExport={onExport}
    />
  );
}

export default BannerExcelBtn;
