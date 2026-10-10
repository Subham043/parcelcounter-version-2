import { useProductDeleteMutation } from "@/utils/data/mutation/product";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function ProductDeleteBtn({ id }: { id: number }) {
  const productDeleteMutation = useProductDeleteMutation(id);

  const onDelete = useCallback(async () => {
    await productDeleteMutation.mutateAsync(undefined);
  }, [productDeleteMutation.mutateAsync]);

  return (
    <DeleteButton
      onDelete={onDelete}
      loading={productDeleteMutation.isPending}
    />
  );
}

export default ProductDeleteBtn;
