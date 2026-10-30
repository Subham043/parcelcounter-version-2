import { Spinner } from "@/components/ui/spinner";
import { useDeleteConfirmation } from "@/hooks/useDeleteConfirmation";
import { Trash } from "lucide-react";
import { useCallback } from "react";
import { DropdownMenuItem } from "../ui/dropdown-menu";

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
    <DropdownMenuItem
      variant="destructive"
      onClick={onDeleteHandler}
      disabled={loading}
    >
      {loading ? <Spinner className="size-5" /> : <Trash />}{" "}
      {loading ? "Deleting..." : "Delete"}
    </DropdownMenuItem>
  );
}

export default DeleteButton;
