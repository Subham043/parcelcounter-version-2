import { useBannerDeleteMutation } from "@/utils/data/mutation/banner";
import { Button } from "@/components/ui/button";
import { useCallback } from "react";
import { Spinner } from "@/components/ui/spinner";
import { useDeleteConfirmation } from "@/hooks/useDeleteConfirmation";

function BannerDeleteBtn({ id }: { id: number }) {
  const { handleDeleteModalOpen } = useDeleteConfirmation();
  const bannerDeleteMutation = useBannerDeleteMutation(id);

  const onDelete = useCallback(
    () =>
      handleDeleteModalOpen(async () => {
        await bannerDeleteMutation.mutateAsync(undefined);
      }),
    [bannerDeleteMutation.mutateAsync],
  );

  return (
    <Button
      size="xs"
      variant="destructive"
      onClick={onDelete}
      disabled={bannerDeleteMutation.isPending}
    >
      {bannerDeleteMutation.isPending && (
        <Spinner className="size-5" data-icon="inline-start" />
      )}
      {bannerDeleteMutation.isPending ? "Deleting..." : "Delete"}
    </Button>
  );
}

export default BannerDeleteBtn;
