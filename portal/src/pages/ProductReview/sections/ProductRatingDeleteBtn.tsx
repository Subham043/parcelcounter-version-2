import { useProductReviewDeleteMutation } from "@/utils/data/mutation/product_review";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function ProductReviewDeleteBtn({
  product_id,
  id,
}: {
  product_id: number;
  id: number;
}) {
  const reviewDeleteMutation = useProductReviewDeleteMutation(product_id, id);

  const onDelete = useCallback(async () => {
    await reviewDeleteMutation.mutateAsync(undefined);
  }, [reviewDeleteMutation.mutateAsync]);

  return (
    <DeleteButton
      onDelete={onDelete}
      loading={reviewDeleteMutation.isPending}
    />
  );
}

export default ProductReviewDeleteBtn;
