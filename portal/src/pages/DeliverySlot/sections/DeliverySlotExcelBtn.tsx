import { useDeliverySlotExportMutation } from "@/utils/data/mutation/delivery_slot";
import { useCallback } from "react";
import ExcelExportButton from "@/components/ExcelExportButton";

function DeliverySlotExcelBtn() {
  const deliverySlotExportMutation = useDeliverySlotExportMutation();

  const onExport = useCallback(async () => {
    await deliverySlotExportMutation.mutateAsync(undefined);
  }, [deliverySlotExportMutation.mutateAsync]);

  return (
    <ExcelExportButton
      loading={deliverySlotExportMutation.isPending}
      onExport={onExport}
    />
  );
}

export default DeliverySlotExcelBtn;
