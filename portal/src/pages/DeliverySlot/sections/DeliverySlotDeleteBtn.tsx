import { useDeliverySlotDeleteMutation } from "@/utils/data/mutation/delivery_slot";
import { Button } from "@/components/ui/button";
import { useCallback } from "react";
import { Spinner } from "@/components/ui/spinner";
import { useDeleteConfirmation } from "@/hooks/useDeleteConfirmation";

function DeliverySlotDeleteBtn({ id }: { id: number }) {
  const { handleDeleteModalOpen } = useDeleteConfirmation();
  const deliverySlotDeleteMutation = useDeliverySlotDeleteMutation(id);

  const onDelete = useCallback(
    () =>
      handleDeleteModalOpen(async () => {
        await deliverySlotDeleteMutation.mutateAsync(undefined);
      }),
    [deliverySlotDeleteMutation.mutateAsync],
  );

  return (
    <Button
      size="xs"
      variant="destructive"
      onClick={onDelete}
      disabled={deliverySlotDeleteMutation.isPending}
    >
      {deliverySlotDeleteMutation.isPending && (
        <Spinner className="size-5" data-icon="inline-start" />
      )}
      {deliverySlotDeleteMutation.isPending ? "Deleting..." : "Delete"}
    </Button>
  );
}

export default DeliverySlotDeleteBtn;
