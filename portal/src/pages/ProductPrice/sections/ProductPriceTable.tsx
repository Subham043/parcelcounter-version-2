import TableRowLoading from "@/components/TableRowLoading";
import type { ProductPriceType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useProductPriceModalStore } from "../store/product-price-modal.store";
import { format } from "date-fns";
import ProductPriceDeleteBtn from "./ProductPriceDeleteBtn";
import TrippleDotMenu from "@/components/TrippleDotMenu";
import EditButton from "@/components/EditButton";

type ProductPriceTableProps = {
  prices: ProductPriceType[];
  loading: boolean;
  product_id: number;
};

const ProductPriceTableRow = memo(function ProductPriceTableRow({
  id,
  price,
  min_quantity,
  created_at,
  product_id,
}: {
  id: ProductPriceType["id"];
  price: ProductPriceType["price"];
  min_quantity: ProductPriceType["min_quantity"];
  created_at: ProductPriceType["created_at"];
  product_id: number;
}) {
  const handleModalEdit = useProductPriceModalStore(
    (state) => state.handleModalEdit,
  );
  const onEditHandler = useCallback(() => {
    handleModalEdit(id);
  }, [id, handleModalEdit]);
  return (
    <tr>
      <td className="px-4 py-3 font-medium text-gray-900">
        <p className="text-sm font-medium text-gray-800">₹{price}</p>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500">{min_quantity}</p>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">
          {format(created_at, "dd MMM yyyy, hh:mm a")}
        </p>
      </td>
      <td className="px-4 py-3 text-right">
        <div className="flex items-center gap-2 justify-end">
          <TrippleDotMenu>
            <EditButton onClick={onEditHandler} />
            <ProductPriceDeleteBtn product_id={product_id} id={id} />
          </TrippleDotMenu>
        </div>
      </td>
    </tr>
  );
});

function ProductPriceTable({
  loading,
  prices,
  product_id,
}: ProductPriceTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {["Price", "Min Quantity", "Created At", ""].map((h) => (
            <th key={h} className="px-4 py-3 text-left font-medium">
              {h}
            </th>
          ))}
        </tr>
      </thead>
      <tbody className="divide-y divide-gray-100">
        {loading ? (
          <TableRowLoading colSpan={4} />
        ) : (
          prices.map((item) => (
            <ProductPriceTableRow
              key={item.id}
              id={item.id}
              price={item.price}
              min_quantity={item.min_quantity}
              created_at={item.created_at}
              product_id={product_id}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(ProductPriceTable);
