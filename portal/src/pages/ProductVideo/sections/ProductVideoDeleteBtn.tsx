import { useProductVideoDeleteMutation } from "@/utils/data/mutation/product_video";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function ProductVideoDeleteBtn({
  product_id,
  id,
}: {
  product_id: number;
  id: number;
}) {
  const videoDeleteMutation = useProductVideoDeleteMutation(product_id, id);

  const onDelete = useCallback(async () => {
    await videoDeleteMutation.mutateAsync(undefined);
  }, [videoDeleteMutation.mutateAsync]);

  return (
    <DeleteButton onDelete={onDelete} loading={videoDeleteMutation.isPending} />
  );
}

export default ProductVideoDeleteBtn;
