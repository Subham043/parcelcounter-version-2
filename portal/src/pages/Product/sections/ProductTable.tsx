import TableRowLoading from "@/components/TableRowLoading";
import type { ProductType } from "@/utils/types";
import { memo, useCallback } from "react";
import { format } from "date-fns";
import ProductDeleteBtn from "./ProductDeleteBtn";
import StatusToggleBadge from "@/components/StatusToggleBadge";
import { useProductToggleStatusMutation } from "@/utils/data/mutation/product";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { getNameInitials } from "@/utils/helper";
import { Link } from "react-router";
import { page_routes } from "@/utils/routes/page_routes";
import { Badge } from "@/components/ui/badge";
import TrippleDotMenu from "@/components/TrippleDotMenu";
import { DropdownMenuItem } from "@/components/ui/dropdown-menu";
import {
  DollarSign,
  Eye,
  Gem,
  Image,
  Layers,
  Paintbrush,
  Pencil,
  StarCheck,
  Video,
} from "lucide-react";

type ProductTableProps = {
  products: ProductType[];
  loading: boolean;
};

const ProductTableRow = memo(function ProductTableRow({
  id,
  name,
  slug,
  hsn,
  categories,
  sub_categories,
  brief_description,
  image_url,
  is_active,
  created_at,
}: {
  id: ProductType["id"];
  name: ProductType["name"];
  slug: ProductType["slug"];
  hsn: ProductType["hsn"];
  brief_description: ProductType["brief_description"];
  image_url: ProductType["image_url"];
  is_active: ProductType["is_active"];
  categories: ProductType["categories"];
  sub_categories: ProductType["sub_categories"];
  created_at: ProductType["created_at"];
}) {
  const subCategoryToggleStatusMutation = useProductToggleStatusMutation(id);

  const onToggle = useCallback(async () => {
    await subCategoryToggleStatusMutation.mutateAsync(undefined);
  }, [subCategoryToggleStatusMutation]);
  return (
    <tr>
      <td className="px-4 py-3 font-medium text-gray-900">
        <div className="flex items-center gap-2 py-1 ">
          <Avatar className="h-8 w-8 rounded-lg">
            <AvatarImage src={image_url} alt={name} />
            <AvatarFallback className="rounded-lg">
              {getNameInitials(name)}
            </AvatarFallback>
          </Avatar>
          <div className="px-1">
            <p className="text-sm font-medium text-gray-800">{name}</p>
          </div>
        </div>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500">{slug}</p>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">{hsn ?? "-"}</p>
      </td>
      <td className="px-4 py-3 ">
        <div className="space-x-1">
          {categories.map((item) => (
            <Badge variant="outline">{item.name}</Badge>
          ))}
        </div>
      </td>
      <td className="px-4 py-3 ">
        <div className="space-x-1">
          {sub_categories.map((item) => (
            <Badge variant="outline">{item.name}</Badge>
          ))}
        </div>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">{brief_description}</p>
      </td>
      <td className="px-4 py-3 ">
        <StatusToggleBadge
          isActive={is_active}
          onToggle={onToggle}
          loading={subCategoryToggleStatusMutation.isPending}
        />
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">
          {format(created_at, "dd MMM yyyy, hh:mm a")}
        </p>
      </td>
      <td className="px-4 py-3 text-right">
        <div className="flex items-center gap-2 justify-end">
          <TrippleDotMenu>
            <DropdownMenuItem
              nativeButton={false}
              render={<Link to={`${page_routes.edit_product.link}/${id}`} />}
            >
              <Pencil /> Edit
            </DropdownMenuItem>
            <DropdownMenuItem
              nativeButton={false}
              render={<Link to={`${page_routes.view_product.link}/${id}`} />}
            >
              <Eye /> View
            </DropdownMenuItem>
            <DropdownMenuItem
              nativeButton={false}
              render={<Link to={`${page_routes.product_prices.link}/${id}`} />}
            >
              <DollarSign /> Prices
            </DropdownMenuItem>
            <DropdownMenuItem
              nativeButton={false}
              render={
                <Link to={`${page_routes.product_specifications.link}/${id}`} />
              }
            >
              <Gem /> Specifications
            </DropdownMenuItem>
            <DropdownMenuItem
              nativeButton={false}
              render={<Link to={`${page_routes.product_stocks.link}/${id}`} />}
            >
              <Layers /> Stocks
            </DropdownMenuItem>
            <DropdownMenuItem
              nativeButton={false}
              render={<Link to={`${page_routes.product_colors.link}/${id}`} />}
            >
              <Paintbrush /> Colors
            </DropdownMenuItem>
            <DropdownMenuItem
              nativeButton={false}
              render={<Link to={`${page_routes.product_images.link}/${id}`} />}
            >
              <Image /> Images
            </DropdownMenuItem>
            <DropdownMenuItem
              nativeButton={false}
              render={<Link to={`${page_routes.product_videos.link}/${id}`} />}
            >
              <Video /> Videos
            </DropdownMenuItem>
            <DropdownMenuItem
              nativeButton={false}
              render={<Link to={`${page_routes.product_reviews.link}/${id}`} />}
            >
              <StarCheck /> Reviews
            </DropdownMenuItem>
            <ProductDeleteBtn id={id} />
          </TrippleDotMenu>
        </div>
      </td>
    </tr>
  );
});

function ProductTable({ loading, products }: ProductTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {[
            "Name",
            "Slug",
            "HSN",
            "Category",
            "Sub-Category",
            "Brief Description",
            "Is Active",
            "Created At",
            "",
          ].map((h) => (
            <th key={h} className="px-4 py-3 text-left font-medium">
              {h}
            </th>
          ))}
        </tr>
      </thead>
      <tbody className="divide-y divide-gray-100">
        {loading ? (
          <TableRowLoading colSpan={9} />
        ) : (
          products.map((item) => (
            <ProductTableRow
              key={item.id}
              id={item.id}
              name={item.name}
              slug={item.slug}
              hsn={item.hsn}
              image_url={item.image_url}
              brief_description={item.brief_description}
              categories={item.categories}
              sub_categories={item.sub_categories}
              is_active={item.is_active}
              created_at={item.created_at}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(ProductTable);
