import TableRowLoading from "@/components/TableRowLoading";
import type { CategoryType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useCategoryModalStore } from "../store/category-modal.store";
import { Button } from "@/components/ui/button";
import { format } from "date-fns";
import CategoryDeleteBtn from "./CategoryDeleteBtn";
import StatusToggleBadge from "@/components/StatusToggleBadge";
import { useCategoryToggleStatusMutation } from "@/utils/data/mutation/category";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { getNameInitials } from "@/utils/helper";

type CategoryTableProps = {
  categories: CategoryType[];
  loading: boolean;
};

const CategoryTableRow = memo(function CategoryTableRow({
  id,
  name,
  slug,
  heading,
  description_unfiltered,
  image_url,
  is_active,
  created_at,
}: {
  id: CategoryType["id"];
  name: CategoryType["name"];
  slug: CategoryType["slug"];
  heading: CategoryType["heading"];
  description_unfiltered: CategoryType["description_unfiltered"];
  image_url: CategoryType["image_url"];
  is_active: CategoryType["is_active"];
  created_at: CategoryType["created_at"];
}) {
  const legalContentToggleStatusMutation = useCategoryToggleStatusMutation(id);

  const onToggle = useCallback(async () => {
    await legalContentToggleStatusMutation.mutateAsync(undefined);
  }, [legalContentToggleStatusMutation]);
  const handleModalEdit = useCategoryModalStore(
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
        <p className="text-sm text-gray-500 truncate">
          {description_unfiltered}
        </p>
      </td>
      <td className="px-4 py-3 ">
        <StatusToggleBadge
          isActive={is_active}
          onToggle={onToggle}
          loading={legalContentToggleStatusMutation.isPending}
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
          <CategoryDeleteBtn id={id} />
        </div>
      </td>
    </tr>
  );
});

function CategoryTable({ loading, categories }: CategoryTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {[
            "Name",
            "Slug",
            "Heading",
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
          <TableRowLoading colSpan={7} />
        ) : (
          categories.map((item) => (
            <CategoryTableRow
              key={item.id}
              id={item.id}
              name={item.name}
              slug={item.slug}
              heading={item.heading}
              image_url={item.image_url}
              description_unfiltered={item.description_unfiltered}
              is_active={item.is_active}
              created_at={item.created_at}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(CategoryTable);
