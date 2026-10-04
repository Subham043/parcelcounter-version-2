import { useBlogExportMutation } from "@/utils/data/mutation/blog";
import { useCallback } from "react";
import ExcelExportButton from "@/components/ExcelExportButton";

function BlogExcelBtn() {
  const blogExportMutation = useBlogExportMutation();

  const onExport = useCallback(async () => {
    await blogExportMutation.mutateAsync(undefined);
  }, [blogExportMutation.mutateAsync]);

  return (
    <ExcelExportButton
      loading={blogExportMutation.isPending}
      onExport={onExport}
    />
  );
}

export default BlogExcelBtn;
