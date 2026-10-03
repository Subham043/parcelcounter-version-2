import { Button } from "@/components/ui/button";
import { Spinner } from "@/components/ui/spinner";
import { useDeleteConfirmation } from "@/hooks/useDeleteConfirmation";
import { useCallback } from "react";

function DeleteButton({
  onDelete,
  loading,
}: {
  onDelete: () => Promise<void>;
  loading: boolean;
}) {
  const { handleDeleteModalOpen } = useDeleteConfirmation();
  const onDeleteHandler = useCallback(
    () =>
      handleDeleteModalOpen(async () => {
        await onDelete();
      }),
    [onDelete],
  );
  return (
    <Button
      size="xs"
      variant="destructive"
      onClick={onDeleteHandler}
      disabled={loading}
    >
      {loading && <Spinner className="size-5" data-icon="inline-start" />}
      {loading ? "Deleting..." : "Delete"}
    </Button>
  );
}

export default DeleteButton;
