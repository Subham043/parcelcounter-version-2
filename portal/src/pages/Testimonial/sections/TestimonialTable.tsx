import TableRowLoading from "@/components/TableRowLoading";
import type { TestimonialType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useTestimonialModalStore } from "../store/testimonial-modal.store";
import { Button } from "@/components/ui/button";
import { format } from "date-fns";
import TestimonialDeleteBtn from "./TestimonialDeleteBtn";
import StatusToggleBadge from "@/components/StatusToggleBadge";
import { useTestimonialToggleStatusMutation } from "@/utils/data/mutation/testimonial";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { getNameInitials } from "@/utils/helper";
import { Star } from "lucide-react";

type TestimonialTableProps = {
  testimonials: TestimonialType[];
  loading: boolean;
};

const TestimonialTableRow = memo(function TestimonialTableRow({
  id,
  name,
  designation,
  star,
  message,
  image_url,
  is_active,
  created_at,
}: {
  id: TestimonialType["id"];
  name: TestimonialType["name"];
  designation: TestimonialType["designation"];
  star: TestimonialType["star"];
  message: TestimonialType["message"];
  image_url: TestimonialType["image_url"];
  is_active: TestimonialType["is_active"];
  created_at: TestimonialType["created_at"];
}) {
  const testimonialToggleStatusMutation =
    useTestimonialToggleStatusMutation(id);

  const onToggle = useCallback(async () => {
    await testimonialToggleStatusMutation.mutateAsync(undefined);
  }, [testimonialToggleStatusMutation]);
  const handleModalEdit = useTestimonialModalStore(
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
            <p className="truncate text-xs text-muted-foreground">
              {designation}
            </p>
          </div>
        </div>
      </td>
      <td className="px-4 py-3">
        <div className="flex items-center gap-1">
          {Array.from({ length: star }).map((_, i) => (
            <Star key={i} className="h-4 w-4 fill-yellow-400 text-yellow-400" />
          ))}
        </div>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">{message}</p>
      </td>
      <td className="px-4 py-3 ">
        <StatusToggleBadge
          isActive={is_active}
          onToggle={onToggle}
          loading={testimonialToggleStatusMutation.isPending}
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
          <TestimonialDeleteBtn id={id} />
        </div>
      </td>
    </tr>
  );
});

function TestimonialTable({ loading, testimonials }: TestimonialTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {["Name", "Rating", "Message", "Is Active", "Created At", ""].map(
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
          <TableRowLoading colSpan={6} />
        ) : (
          testimonials.map((item) => (
            <TestimonialTableRow
              key={item.id}
              id={item.id}
              name={item.name}
              designation={item.designation}
              star={item.star}
              message={item.message}
              image_url={item.image_url}
              is_active={item.is_active}
              created_at={item.created_at}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(TestimonialTable);
