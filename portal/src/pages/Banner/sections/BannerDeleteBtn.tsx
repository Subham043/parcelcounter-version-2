import DeleteButton from "@/components/DeleteButton";
import { useBannerDeleteMutation } from "@/utils/data/mutation/banner";
import { useCallback } from "react";

function BannerDeleteBtn({ id }: { id: number }) {
  const bannerDeleteMutation = useBannerDeleteMutation(id);

  const onDelete = useCallback(async () => {
    await bannerDeleteMutation.mutateAsync(undefined);
  }, [bannerDeleteMutation.mutateAsync]);

  return (
    <DeleteButton
      onDelete={onDelete}
      loading={bannerDeleteMutation.isPending}
    />
  );
}

export default BannerDeleteBtn;
