import { useProductColorDeleteMutation } from "@/utils/data/mutation/product_color";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function ProductColorDeleteBtn({
  product_id,
  id,
}: {
  product_id: number;
  id: number;
}) {
  const colorDeleteMutation = useProductColorDeleteMutation(product_id, id);

  const onDelete = useCallback(async () => {
    await colorDeleteMutation.mutateAsync(undefined);
  }, [colorDeleteMutation.mutateAsync]);

  return (
    <DeleteButton onDelete={onDelete} loading={colorDeleteMutation.isPending} />
  );
}

export default ProductColorDeleteBtn;
