import { useProductSpecificationDeleteMutation } from "@/utils/data/mutation/product_specification";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function ProductSpecificationDeleteBtn({
  product_id,
  id,
}: {
  product_id: number;
  id: number;
}) {
  const specificationDeleteMutation = useProductSpecificationDeleteMutation(
    product_id,
    id,
  );

  const onDelete = useCallback(async () => {
    await specificationDeleteMutation.mutateAsync(undefined);
  }, [specificationDeleteMutation.mutateAsync]);

  return (
    <DeleteButton
      onDelete={onDelete}
      loading={specificationDeleteMutation.isPending}
    />
  );
}

export default ProductSpecificationDeleteBtn;
