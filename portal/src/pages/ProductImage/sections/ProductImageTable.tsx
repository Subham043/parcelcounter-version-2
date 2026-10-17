import TableRowLoading from "@/components/TableRowLoading";
import type { ProductImageType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useProductImageModalStore } from "../store/product-image-modal.store";
import { Button } from "@/components/ui/button";
import { format } from "date-fns";
import ProductImageDeleteBtn from "./ProductImageDeleteBtn";
import { Avatar, AvatarImage } from "@/components/ui/avatar";

type ProductImageTableProps = {
  images: ProductImageType[];
  loading: boolean;
  product_id: number;
};

const ProductImageTableRow = memo(function ProductImageTableRow({
  id,
  image_title,
  image_alt,
  image_url,
  created_at,
  product_id,
}: {
  id: ProductImageType["id"];
  image_title: ProductImageType["image_title"];
  image_alt: ProductImageType["image_alt"];
  image_url: ProductImageType["image_url"];
  created_at: ProductImageType["created_at"];
  product_id: number;
}) {
  const handleModalEdit = useProductImageModalStore(
    (state) => state.handleModalEdit,
  );
  const onEditHandler = useCallback(() => {
    handleModalEdit(id);
  }, [id, handleModalEdit]);
  return (
    <tr>
      <td className="px-4 py-3 font-medium text-gray-900">
        <Avatar className="h-8 w-8 rounded-lg">
          <AvatarImage src={image_url} alt={image_title} />
        </Avatar>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">{image_title}</p>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">{image_alt}</p>
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
          <ProductImageDeleteBtn product_id={product_id} id={id} />
        </div>
      </td>
    </tr>
  );
});

function ProductImageTable({
  loading,
  images,
  product_id,
}: ProductImageTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {["Image", "Title", "Alt", "Created At", ""].map((h) => (
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
          images.map((item) => (
            <ProductImageTableRow
              key={item.id}
              id={item.id}
              image_title={item.image_title}
              image_alt={item.image_alt}
              image_url={item.image_url}
              created_at={item.created_at}
              product_id={product_id}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(ProductImageTable);
