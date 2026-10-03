import { useDeliverySlotDeleteMutation } from "@/utils/data/mutation/delivery_slot";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function DeliverySlotDeleteBtn({ id }: { id: number }) {
  const deliverySlotDeleteMutation = useDeliverySlotDeleteMutation(id);

  const onDelete = useCallback(async () => {
    await deliverySlotDeleteMutation.mutateAsync(undefined);
  }, [deliverySlotDeleteMutation.mutateAsync]);

  return (
    <DeleteButton
      onDelete={onDelete}
      loading={deliverySlotDeleteMutation.isPending}
    />
  );
}

export default DeliverySlotDeleteBtn;
