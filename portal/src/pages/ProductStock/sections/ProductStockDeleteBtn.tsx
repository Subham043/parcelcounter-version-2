import { useProductStockDeleteMutation } from "@/utils/data/mutation/product_stock";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function ProductStockDeleteBtn({
  product_id,
  id,
}: {
  product_id: number;
  id: number;
}) {
  const stockDeleteMutation = useProductStockDeleteMutation(product_id, id);

  const onDelete = useCallback(async () => {
    await stockDeleteMutation.mutateAsync(undefined);
  }, [stockDeleteMutation.mutateAsync]);

  return (
    <DeleteButton onDelete={onDelete} loading={stockDeleteMutation.isPending} />
  );
}

export default ProductStockDeleteBtn;
