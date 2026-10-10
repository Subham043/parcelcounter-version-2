import { useProductExportMutation } from "@/utils/data/mutation/product";
import { useCallback } from "react";
import ExcelExportButton from "@/components/ExcelExportButton";

function ProductExcelBtn() {
  const productExportMutation = useProductExportMutation();

  const onExport = useCallback(async () => {
    await productExportMutation.mutateAsync(undefined);
  }, [productExportMutation.mutateAsync]);

  return (
    <ExcelExportButton
      loading={productExportMutation.isPending}
      onExport={onExport}
    />
  );
}

export default ProductExcelBtn;
