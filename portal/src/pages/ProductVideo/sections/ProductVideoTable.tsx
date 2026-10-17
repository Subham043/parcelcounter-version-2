import TableRowLoading from "@/components/TableRowLoading";
import type { ProductVideoType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useProductVideoModalStore } from "../store/product-video-modal.store";
import { Button } from "@/components/ui/button";
import { format } from "date-fns";
import ProductVideoDeleteBtn from "./ProductVideoDeleteBtn";

type ProductVideoTableProps = {
  videos: ProductVideoType[];
  loading: boolean;
  product_id: number;
};

const ProductVideoTableRow = memo(function ProductVideoTableRow({
  id,
  video,
  created_at,
  product_id,
}: {
  id: ProductVideoType["id"];
  video: ProductVideoType["video"];
  created_at: ProductVideoType["created_at"];
  product_id: number;
}) {
  const handleModalEdit = useProductVideoModalStore(
    (state) => state.handleModalEdit,
  );
  const onEditHandler = useCallback(() => {
    handleModalEdit(id);
  }, [id, handleModalEdit]);
  return (
    <tr>
      <td className="px-4 py-3 font-medium text-gray-900">
        <p className="text-sm font-medium text-gray-800">{video}</p>
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
          <ProductVideoDeleteBtn product_id={product_id} id={id} />
        </div>
      </td>
    </tr>
  );
});

function ProductVideoTable({
  loading,
  videos,
  product_id,
}: ProductVideoTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {["URL", "Created At", ""].map((h) => (
            <th key={h} className="px-4 py-3 text-left font-medium">
              {h}
            </th>
          ))}
        </tr>
      </thead>
      <tbody className="divide-y divide-gray-100">
        {loading ? (
          <TableRowLoading colSpan={3} />
        ) : (
          videos.map((item) => (
            <ProductVideoTableRow
              key={item.id}
              id={item.id}
              video={item.video}
              created_at={item.created_at}
              product_id={product_id}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(ProductVideoTable);
