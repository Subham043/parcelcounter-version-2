import { useChargeDeleteMutation } from "@/utils/data/mutation/charge";
import { Button } from "@/components/ui/button";
import { useCallback } from "react";
import { Spinner } from "@/components/ui/spinner";
import { useDeleteConfirmation } from "@/hooks/useDeleteConfirmation";

function ChargeDeleteBtn({ id }: { id: number }) {
  const { handleDeleteModalOpen } = useDeleteConfirmation();
  const chargeDeleteMutation = useChargeDeleteMutation(id);

  const onDelete = useCallback(
    () =>
      handleDeleteModalOpen(async () => {
        await chargeDeleteMutation.mutateAsync(undefined);
      }),
    [chargeDeleteMutation.mutateAsync],
  );

  return (
    <Button
      size="xs"
      variant="destructive"
      onClick={onDelete}
      disabled={chargeDeleteMutation.isPending}
    >
      {chargeDeleteMutation.isPending && (
        <Spinner className="size-5" data-icon="inline-start" />
      )}
      {chargeDeleteMutation.isPending ? "Deleting..." : "Delete"}
    </Button>
  );
}

export default ChargeDeleteBtn;
