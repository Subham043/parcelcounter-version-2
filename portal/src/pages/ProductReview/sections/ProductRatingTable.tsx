import TableRowLoading from "@/components/TableRowLoading";
import type { ProductReviewType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useProductReviewModalStore } from "../store/product-review-modal.store";
import { Button } from "@/components/ui/button";
import { format } from "date-fns";
import ProductReviewDeleteBtn from "./ProductRatingDeleteBtn";
import { Star } from "lucide-react";
import StatusToggleBadge from "@/components/StatusToggleBadge";
import { useProductReviewToggleStatusMutation } from "@/utils/data/mutation/product_review";

type ProductReviewTableProps = {
  reviews: ProductReviewType[];
  loading: boolean;
  product_id: number;
};

const ProductReviewTableRow = memo(function ProductReviewTableRow({
  id,
  rating,
  comment,
  is_active,
  created_at,
  product_id,
}: {
  id: ProductReviewType["id"];
  rating: ProductReviewType["rating"];
  comment: ProductReviewType["comment"];
  is_active: ProductReviewType["is_active"];
  created_at: ProductReviewType["created_at"];
  product_id: number;
}) {
  const handleModalEdit = useProductReviewModalStore(
    (state) => state.handleModalEdit,
  );
  const onEditHandler = useCallback(() => {
    handleModalEdit(id);
  }, [id, handleModalEdit]);

  const reviewToggleStatusMutation = useProductReviewToggleStatusMutation(
    product_id,
    id,
  );

  const onToggle = useCallback(async () => {
    await reviewToggleStatusMutation.mutateAsync(undefined);
  }, [reviewToggleStatusMutation]);

  return (
    <tr>
      <td className="px-4 py-3">
        <div className="flex items-center gap-1">
          {Array.from({ length: rating }).map((_, i) => (
            <Star key={i} className="h-4 w-4 fill-yellow-400 text-yellow-400" />
          ))}
        </div>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">{comment}</p>
      </td>
      <td className="px-4 py-3 ">
        <StatusToggleBadge
          isActive={is_active}
          onToggle={onToggle}
          loading={reviewToggleStatusMutation.isPending}
        />
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">
          {format(created_at, "dd MMM yyyy, hh:mm a")}
        </p>
      </td>
      <td className="px-4 py-3 text-right">
        <div className="flex items-center gap-2 justify-end">
          <Button size="xs" variant="secondary" onClick={onEditHandler}>
            Edit
          </Button>
          <ProductReviewDeleteBtn product_id={product_id} id={id} />
        </div>
      </td>
    </tr>
  );
});

function ProductReviewTable({
  loading,
  reviews,
  product_id,
}: ProductReviewTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {["Rating", "Comment", "Is Active", "Created At", ""].map((h) => (
            <th key={h} className="px-4 py-3 text-left font-medium">
              {h}
            </th>
          ))}
        </tr>
      </thead>
      <tbody className="divide-y divide-gray-100">
        {loading ? (
          <TableRowLoading colSpan={5} />
        ) : (
          reviews.map((item) => (
            <ProductReviewTableRow
              key={item.id}
              id={item.id}
              rating={item.rating}
              comment={item.comment}
              is_active={item.is_active}
              created_at={item.created_at}
              product_id={product_id}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(ProductReviewTable);
