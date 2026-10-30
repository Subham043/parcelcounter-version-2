import TableRowLoading from "@/components/TableRowLoading";
import type { ProductSpecificationType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useProductSpecificationModalStore } from "../store/product-specification-modal.store";
import { format } from "date-fns";
import ProductSpecificationDeleteBtn from "./ProductSpecificationDeleteBtn";
import TrippleDotMenu from "@/components/TrippleDotMenu";
import EditButton from "@/components/EditButton";

type ProductSpecificationTableProps = {
  specifications: ProductSpecificationType[];
  loading: boolean;
  product_id: number;
};

const ProductSpecificationTableRow = memo(
  function ProductSpecificationTableRow({
    id,
    title,
    description,
    created_at,
    product_id,
  }: {
    id: ProductSpecificationType["id"];
    title: ProductSpecificationType["title"];
    description: ProductSpecificationType["description"];
    created_at: ProductSpecificationType["created_at"];
    product_id: number;
  }) {
    const handleModalEdit = useProductSpecificationModalStore(
      (state) => state.handleModalEdit,
    );
    const onEditHandler = useCallback(() => {
      handleModalEdit(id);
    }, [id, handleModalEdit]);
    return (
      <tr>
        <td className="px-4 py-3 font-medium text-gray-900">
          <p className="text-sm font-medium text-gray-800">{title}</p>
        </td>
        <td className="px-4 py-3 ">
          <p className="text-sm text-gray-500 truncate">{description}</p>
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
              <ProductSpecificationDeleteBtn product_id={product_id} id={id} />
            </TrippleDotMenu>
          </div>
        </td>
      </tr>
    );
  },
);

function ProductSpecificationTable({
  loading,
  specifications,
  product_id,
}: ProductSpecificationTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {["Title", "Description", "Created At", ""].map((h) => (
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
          specifications.map((item) => (
            <ProductSpecificationTableRow
              key={item.id}
              id={item.id}
              title={item.title}
              description={item.description}
              created_at={item.created_at}
              product_id={product_id}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(ProductSpecificationTable);
