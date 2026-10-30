import TableRowLoading from "@/components/TableRowLoading";
import type { ProductColorType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useProductColorModalStore } from "../store/product-color-modal.store";
import { format } from "date-fns";
import ProductColorDeleteBtn from "./ProductColorDeleteBtn";
import TrippleDotMenu from "@/components/TrippleDotMenu";
import EditButton from "@/components/EditButton";

type ProductColorTableProps = {
  colors: ProductColorType[];
  loading: boolean;
  product_id: number;
};

const ProductColorTableRow = memo(function ProductColorTableRow({
  id,
  name,
  code,
  created_at,
  product_id,
}: {
  id: ProductColorType["id"];
  name: ProductColorType["name"];
  code: ProductColorType["code"];
  created_at: ProductColorType["created_at"];
  product_id: number;
}) {
  const handleModalEdit = useProductColorModalStore(
    (state) => state.handleModalEdit,
  );
  const onEditHandler = useCallback(() => {
    handleModalEdit(id);
  }, [id, handleModalEdit]);
  return (
    <tr>
      <td className="px-4 py-3 font-medium text-gray-900">
        <p className="text-sm font-medium text-gray-800">{name}</p>
      </td>
      <td className="px-4 py-3 ">
        <div className="flex items-center gap-2">
          <div
            className="w-3 h-3 rounded-full"
            style={{ backgroundColor: code }}
          />
          <p className="text-sm text-gray-500">{code}</p>
        </div>
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
            <ProductColorDeleteBtn product_id={product_id} id={id} />
          </TrippleDotMenu>
        </div>
      </td>
    </tr>
  );
});

function ProductColorTable({
  loading,
  colors,
  product_id,
}: ProductColorTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {["Name", "Code", "Created At", ""].map((h) => (
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
          colors.map((item) => (
            <ProductColorTableRow
              key={item.id}
              id={item.id}
              name={item.name}
              code={item.code}
              created_at={item.created_at}
              product_id={product_id}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(ProductColorTable);
