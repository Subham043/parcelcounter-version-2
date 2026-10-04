import { usePaymentOptionExportMutation } from "@/utils/data/mutation/payment_option";
import { useCallback } from "react";
import ExcelExportButton from "@/components/ExcelExportButton";

function PaymentOptionExcelBtn() {
  const paymentOptionExportMutation = usePaymentOptionExportMutation();

  const onExport = useCallback(async () => {
    await paymentOptionExportMutation.mutateAsync(undefined);
  }, [paymentOptionExportMutation.mutateAsync]);

  return (
    <ExcelExportButton
      loading={paymentOptionExportMutation.isPending}
      onExport={onExport}
    />
  );
}

export default PaymentOptionExcelBtn;
