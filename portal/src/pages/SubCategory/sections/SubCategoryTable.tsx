import TableRowLoading from "@/components/TableRowLoading";
import type { SubCategoryType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useSubCategoryModalStore } from "../store/sub-category-modal.store";
import { Button } from "@/components/ui/button";
import { format } from "date-fns";
import SubCategoryDeleteBtn from "./SubCategoryDeleteBtn";
import StatusToggleBadge from "@/components/StatusToggleBadge";
import { useSubCategoryToggleStatusMutation } from "@/utils/data/mutation/sub_category";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { getNameInitials } from "@/utils/helper";

type SubCategoryTableProps = {
  subCategories: SubCategoryType[];
  loading: boolean;
};

const SubCategoryTableRow = memo(function SubCategoryTableRow({
  id,
  name,
  slug,
  heading,
  categories,
  description_unfiltered,
  image_url,
  is_active,
  created_at,
}: {
  id: SubCategoryType["id"];
  name: SubCategoryType["name"];
  slug: SubCategoryType["slug"];
  heading: SubCategoryType["heading"];
  description_unfiltered: SubCategoryType["description_unfiltered"];
  image_url: SubCategoryType["image_url"];
  is_active: SubCategoryType["is_active"];
  categories: SubCategoryType["categories"];
  created_at: SubCategoryType["created_at"];
}) {
  const subCategoryToggleStatusMutation =
    useSubCategoryToggleStatusMutation(id);

  const onToggle = useCallback(async () => {
    await subCategoryToggleStatusMutation.mutateAsync(undefined);
  }, [subCategoryToggleStatusMutation]);
  const handleModalEdit = useSubCategoryModalStore(
    (state) => state.handleModalEdit,
  );
  const onEditHandler = useCallback(() => {
    handleModalEdit(id);
  }, [id, handleModalEdit]);
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
        <p className="text-sm text-gray-500 truncate">{heading}</p>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500">
          {categories.map((item) => item.name).join(", ")}
        </p>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">
          {description_unfiltered}
        </p>
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
          <Button size="xs" variant="secondary" onClick={onEditHandler}>
            Edit
          </Button>
          <SubCategoryDeleteBtn id={id} />
        </div>
      </td>
    </tr>
  );
});

function SubCategoryTable({ loading, subCategories }: SubCategoryTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {[
            "Name",
            "Slug",
            "Heading",
            "Category",
            "Description",
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
          <TableRowLoading colSpan={8} />
        ) : (
          subCategories.map((item) => (
            <SubCategoryTableRow
              key={item.id}
              id={item.id}
              name={item.name}
              slug={item.slug}
              heading={item.heading}
              image_url={item.image_url}
              description_unfiltered={item.description_unfiltered}
              categories={item.categories}
              is_active={item.is_active}
              created_at={item.created_at}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(SubCategoryTable);
