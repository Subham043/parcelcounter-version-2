import { useProductImageDeleteMutation } from "@/utils/data/mutation/product_image";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function ProductImageDeleteBtn({
  product_id,
  id,
}: {
  product_id: number;
  id: number;
}) {
  const imageDeleteMutation = useProductImageDeleteMutation(product_id, id);

  const onDelete = useCallback(async () => {
    await imageDeleteMutation.mutateAsync(undefined);
  }, [imageDeleteMutation.mutateAsync]);

  return (
    <DeleteButton onDelete={onDelete} loading={imageDeleteMutation.isPending} />
  );
}

export default ProductImageDeleteBtn;
