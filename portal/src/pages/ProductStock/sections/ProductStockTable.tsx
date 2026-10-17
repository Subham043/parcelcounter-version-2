import TableRowLoading from "@/components/TableRowLoading";
import type { ProductStockType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useProductStockModalStore } from "../store/product-stock-modal.store";
import { Button } from "@/components/ui/button";
import { format } from "date-fns";
import ProductStockDeleteBtn from "./ProductStockDeleteBtn";

type ProductStockTableProps = {
  stocks: ProductStockType[];
  loading: boolean;
  product_id: number;
};

const ProductStockTableRow = memo(function ProductStockTableRow({
  id,
  purchase_stock,
  quantity,
  purchased_at,
  created_at,
  product_id,
}: {
  id: ProductStockType["id"];
  purchase_stock: ProductStockType["purchase_stock"];
  quantity: ProductStockType["quantity"];
  purchased_at: ProductStockType["purchased_at"];
  created_at: ProductStockType["created_at"];
  product_id: number;
}) {
  const handleModalEdit = useProductStockModalStore(
    (state) => state.handleModalEdit,
  );
  const onEditHandler = useCallback(() => {
    handleModalEdit(id);
  }, [id, handleModalEdit]);
  return (
    <tr>
      <td className="px-4 py-3 font-medium text-gray-900">
        <p className="text-sm font-medium text-gray-800">₹{purchase_stock}</p>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500">{quantity}</p>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">
          {format(purchased_at, "dd MMM yyyy")}
        </p>
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
          <ProductStockDeleteBtn product_id={product_id} id={id} />
        </div>
      </td>
    </tr>
  );
});

function ProductStockTable({
  loading,
  stocks,
  product_id,
}: ProductStockTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {["Purchase Price", "Quantity", "Purchased At", "Created At", ""].map(
            (h) => (
              <th key={h} className="px-4 py-3 text-left font-medium">
                {h}
              </th>
            ),
          )}
        </tr>
      </thead>
      <tbody className="divide-y divide-gray-100">
        {loading ? (
          <TableRowLoading colSpan={5} />
        ) : (
          stocks.map((item) => (
            <ProductStockTableRow
              key={item.id}
              id={item.id}
              purchase_stock={item.purchase_stock}
              quantity={item.quantity}
              purchased_at={item.purchased_at}
              created_at={item.created_at}
              product_id={product_id}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(ProductStockTable);
