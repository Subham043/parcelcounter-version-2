import { useAboutSectionExportMutation } from "@/utils/data/mutation/about_section";
import { useCallback } from "react";
import ExcelExportButton from "@/components/ExcelExportButton";

function AboutSectionExcelBtn() {
  const aboutSectionExportMutation = useAboutSectionExportMutation();

  const onExport = useCallback(async () => {
    await aboutSectionExportMutation.mutateAsync(undefined);
  }, [aboutSectionExportMutation.mutateAsync]);

  return (
    <ExcelExportButton
      loading={aboutSectionExportMutation.isPending}
      onExport={onExport}
    />
  );
}

export default AboutSectionExcelBtn;
