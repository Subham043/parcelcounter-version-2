import TableRowLoading from "@/components/TableRowLoading";
import type { BlogType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useBlogModalStore } from "../store/blog-modal.store";
import { Button } from "@/components/ui/button";
import { format } from "date-fns";
import BlogDeleteBtn from "./BlogDeleteBtn";
import StatusToggleBadge from "@/components/StatusToggleBadge";
import { useBlogToggleStatusMutation } from "@/utils/data/mutation/blog";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { getNameInitials } from "@/utils/helper";
import ActiveBadge from "@/components/ActiveBadge";

type BlogTableProps = {
  blogs: BlogType[];
  loading: boolean;
};

const BlogTableRow = memo(function BlogTableRow({
  id,
  name,
  slug,
  heading,
  description_unfiltered,
  image_url,
  is_active,
  is_popular,
  created_at,
}: {
  id: BlogType["id"];
  name: BlogType["name"];
  slug: BlogType["slug"];
  heading: BlogType["heading"];
  description_unfiltered: BlogType["description_unfiltered"];
  image_url: BlogType["image_url"];
  is_active: BlogType["is_active"];
  is_popular: BlogType["is_popular"];
  created_at: BlogType["created_at"];
}) {
  const legalContentToggleStatusMutation = useBlogToggleStatusMutation(id);

  const onToggle = useCallback(async () => {
    await legalContentToggleStatusMutation.mutateAsync(undefined);
  }, [legalContentToggleStatusMutation]);
  const handleModalEdit = useBlogModalStore((state) => state.handleModalEdit);
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
        <ActiveBadge value={is_popular} />
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
          <BlogDeleteBtn id={id} />
        </div>
      </td>
    </tr>
  );
});

function BlogTable({ loading, blogs }: BlogTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {[
            "Name",
            "Slug",
            "Heading",
            "Description",
            "Is Popular",
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
          blogs.map((item) => (
            <BlogTableRow
              key={item.id}
              id={item.id}
              name={item.name}
              slug={item.slug}
              heading={item.heading}
              image_url={item.image_url}
              description_unfiltered={item.description_unfiltered}
              is_active={item.is_active}
              is_popular={item.is_popular}
              created_at={item.created_at}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(BlogTable);
