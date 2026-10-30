import TableRowLoading from "@/components/TableRowLoading";
import type { CertificationType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useCertificationModalStore } from "../store/certification-modal.store";
import { Button } from "@/components/ui/button";
import { format } from "date-fns";
import CertificationDeleteBtn from "./CertificationDeleteBtn";
import StatusToggleBadge from "@/components/StatusToggleBadge";
import { useCertificationToggleStatusMutation } from "@/utils/data/mutation/certification";
import { Avatar, AvatarImage } from "@/components/ui/avatar";

type CertificationTableProps = {
  certifications: CertificationType[];
  loading: boolean;
};

const CertificationTableRow = memo(function CertificationTableRow({
  id,
  title,
  image_url,
  is_active,
  created_at,
}: {
  id: CertificationType["id"];
  title: CertificationType["title"];
  image_url: CertificationType["image_url"];
  is_active: CertificationType["is_active"];
  created_at: CertificationType["created_at"];
}) {
  const certificationToggleStatusMutation =
    useCertificationToggleStatusMutation(id);

  const onToggle = useCallback(async () => {
    await certificationToggleStatusMutation.mutateAsync(undefined);
  }, [certificationToggleStatusMutation]);
  const handleModalEdit = useCertificationModalStore(
    (state) => state.handleModalEdit,
  );
  const onEditHandler = useCallback(() => {
    handleModalEdit(id);
  }, [id, handleModalEdit]);
  return (
    <tr>
      <td className="px-4 py-3 font-medium text-gray-900">
        <Avatar className="h-8 w-8 rounded-lg">
          <AvatarImage src={image_url} alt={title} />
        </Avatar>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">{title}</p>
      </td>
      <td className="px-4 py-3 ">
        <StatusToggleBadge
          isActive={is_active}
          onToggle={onToggle}
          loading={certificationToggleStatusMutation.isPending}
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
          <CertificationDeleteBtn id={id} />
        </div>
      </td>
    </tr>
  );
});

function CertificationTable({
  loading,
  certifications,
}: CertificationTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {["Image", "Title", "Is Active", "Created At", ""].map((h) => (
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
          certifications.map((item) => (
            <CertificationTableRow
              key={item.id}
              id={item.id}
              title={item.title}
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

export default memo(CertificationTable);
