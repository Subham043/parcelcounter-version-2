import { useFeatureDeleteMutation } from "@/utils/data/mutation/feature";
import { Button } from "@/components/ui/button";
import { useCallback } from "react";
import { Spinner } from "@/components/ui/spinner";
import { useDeleteConfirmation } from "@/hooks/useDeleteConfirmation";

function FeatureDeleteBtn({ id }: { id: number }) {
  const { handleDeleteModalOpen } = useDeleteConfirmation();
  const featureDeleteMutation = useFeatureDeleteMutation(id);

  const onDelete = useCallback(
    () =>
      handleDeleteModalOpen(async () => {
        await featureDeleteMutation.mutateAsync(undefined);
      }),
    [featureDeleteMutation.mutateAsync],
  );

  return (
    <Button
      size="xs"
      variant="destructive"
      onClick={onDelete}
      disabled={featureDeleteMutation.isPending}
    >
      {featureDeleteMutation.isPending && (
        <Spinner className="size-5" data-icon="inline-start" />
      )}
      {featureDeleteMutation.isPending ? "Deleting..." : "Delete"}
    </Button>
  );
}

export default FeatureDeleteBtn;
