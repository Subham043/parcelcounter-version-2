import { useProductPriceDeleteMutation } from "@/utils/data/mutation/product_price";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function ProductPriceDeleteBtn({
  product_id,
  id,
}: {
  product_id: number;
  id: number;
}) {
  const priceDeleteMutation = useProductPriceDeleteMutation(product_id, id);

  const onDelete = useCallback(async () => {
    await priceDeleteMutation.mutateAsync(undefined);
  }, [priceDeleteMutation.mutateAsync]);

  return (
    <DeleteButton onDelete={onDelete} loading={priceDeleteMutation.isPending} />
  );
}

export default ProductPriceDeleteBtn;
