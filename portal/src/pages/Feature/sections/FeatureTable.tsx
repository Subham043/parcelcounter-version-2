import TableRowLoading from "@/components/TableRowLoading";
import type { FeatureType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useFeatureModalStore } from "../store/feature-modal.store";
import { Button } from "@/components/ui/button";
import { format } from "date-fns";
import FeatureDeleteBtn from "./FeatureDeleteBtn";
import StatusToggleBadge from "@/components/StatusToggleBadge";
import { useFeatureToggleStatusMutation } from "@/utils/data/mutation/feature";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { getNameInitials } from "@/utils/helper";

type FeatureTableProps = {
  features: FeatureType[];
  loading: boolean;
};

const FeatureTableRow = memo(function FeatureTableRow({
  id,
  title,
  description,
  image_url,
  is_active,
  created_at,
}: {
  id: FeatureType["id"];
  title: FeatureType["title"];
  description: FeatureType["description"];
  image_url: FeatureType["image_url"];
  is_active: FeatureType["is_active"];
  created_at: FeatureType["created_at"];
}) {
  const featureToggleStatusMutation = useFeatureToggleStatusMutation(id);

  const onToggle = useCallback(async () => {
    await featureToggleStatusMutation.mutateAsync(undefined);
  }, [featureToggleStatusMutation]);
  const handleModalEdit = useFeatureModalStore(
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
            <AvatarImage src={image_url} alt={title} />
            <AvatarFallback className="rounded-lg">
              {getNameInitials(title)}
            </AvatarFallback>
          </Avatar>
          <div className="px-1">
            <p className="text-sm font-medium text-gray-800">{title}</p>
          </div>
        </div>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">{description}</p>
      </td>
      <td className="px-4 py-3 ">
        <StatusToggleBadge
          isActive={is_active}
          onToggle={onToggle}
          loading={featureToggleStatusMutation.isPending}
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
          <FeatureDeleteBtn id={id} />
        </div>
      </td>
    </tr>
  );
});

function FeatureTable({ loading, features }: FeatureTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {["Title", "Description", "Is Active", "Created At", ""].map((h) => (
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
          features.map((item) => (
            <FeatureTableRow
              key={item.id}
              id={item.id}
              title={item.title}
              description={item.description}
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

export default memo(FeatureTable);
