import TableRowLoading from "@/components/TableRowLoading";
import type { BannerType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useBannerModalStore } from "../store/banner-modal.store";
import { Button } from "@/components/ui/button";
import { format } from "date-fns";
import BannerDeleteBtn from "./BannerDeleteBtn";
import StatusToggleBadge from "@/components/StatusToggleBadge";
import { useBannerToggleStatusMutation } from "@/utils/data/mutation/banner";
import { Avatar, AvatarImage } from "@/components/ui/avatar";

type BannerTableProps = {
  banners: BannerType[];
  loading: boolean;
};

const BannerTableRow = memo(function BannerTableRow({
  id,
  title,
  alt,
  desktop_image_url,
  mobile_image_url,
  is_active,
  created_at,
}: {
  id: BannerType["id"];
  title: BannerType["title"];
  alt: BannerType["alt"];
  desktop_image_url: BannerType["desktop_image_url"];
  mobile_image_url: BannerType["mobile_image_url"];
  is_active: BannerType["is_active"];
  created_at: BannerType["created_at"];
}) {
  const bannerToggleStatusMutation = useBannerToggleStatusMutation(id);

  const onToggle = useCallback(async () => {
    await bannerToggleStatusMutation.mutateAsync(undefined);
  }, [bannerToggleStatusMutation]);
  const handleModalEdit = useBannerModalStore((state) => state.handleModalEdit);
  const onEditHandler = useCallback(() => {
    handleModalEdit(id);
  }, [id, handleModalEdit]);
  return (
    <tr>
      <td className="px-4 py-3 font-medium text-gray-900">
        <Avatar className="h-8 w-8 rounded-lg">
          <AvatarImage src={desktop_image_url} alt={title} />
        </Avatar>
      </td>
      <td className="px-4 py-3 font-medium text-gray-900">
        <Avatar className="h-8 w-8 rounded-lg">
          <AvatarImage src={mobile_image_url} alt={title} />
        </Avatar>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">{title}</p>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">{alt}</p>
      </td>
      <td className="px-4 py-3 ">
        <StatusToggleBadge
          isActive={is_active}
          onToggle={onToggle}
          loading={bannerToggleStatusMutation.isPending}
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
          <BannerDeleteBtn id={id} />
        </div>
      </td>
    </tr>
  );
});

function BannerTable({ loading, banners }: BannerTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {[
            "Desktop",
            "Mobile",
            "Title",
            "Alt",
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
          banners.map((item) => (
            <BannerTableRow
              key={item.id}
              id={item.id}
              title={item.title}
              alt={item.alt}
              desktop_image_url={item.desktop_image_url}
              mobile_image_url={item.mobile_image_url}
              is_active={item.is_active}
              created_at={item.created_at}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(BannerTable);
