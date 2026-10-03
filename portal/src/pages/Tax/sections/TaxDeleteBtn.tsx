import { useTaxDeleteMutation } from "@/utils/data/mutation/tax";
import { Button } from "@/components/ui/button";
import { useCallback } from "react";
import { Spinner } from "@/components/ui/spinner";
import { useDeleteConfirmation } from "@/hooks/useDeleteConfirmation";

function TaxDeleteBtn({ id }: { id: number }) {
  const { handleDeleteModalOpen } = useDeleteConfirmation();
  const taxDeleteMutation = useTaxDeleteMutation(id);

  const onDelete = useCallback(
    () =>
      handleDeleteModalOpen(async () => {
        await taxDeleteMutation.mutateAsync(undefined);
      }),
    [taxDeleteMutation.mutateAsync],
  );

  return (
    <Button
      size="xs"
      variant="destructive"
      onClick={onDelete}
      disabled={taxDeleteMutation.isPending}
    >
      {taxDeleteMutation.isPending && (
        <Spinner className="size-5" data-icon="inline-start" />
      )}
      {taxDeleteMutation.isPending ? "Deleting..." : "Delete"}
    </Button>
  );
}

export default TaxDeleteBtn;
