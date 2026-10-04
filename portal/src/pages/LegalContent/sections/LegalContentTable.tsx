import TableRowLoading from "@/components/TableRowLoading";
import type { LegalContentType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useLegalContentModalStore } from "../store/legal-content-modal.store";
import { Button } from "@/components/ui/button";
import { format } from "date-fns";
import LegalContentDeleteBtn from "./LegalContentDeleteBtn";
import StatusToggleBadge from "@/components/StatusToggleBadge";
import { useLegalContentToggleStatusMutation } from "@/utils/data/mutation/legal_content";

type LegalContentTableProps = {
  legalContents: LegalContentType[];
  loading: boolean;
};

const LegalContentTableRow = memo(function LegalContentTableRow({
  id,
  name,
  slug,
  heading,
  description_unfiltered,
  is_active,
  created_at,
}: {
  id: LegalContentType["id"];
  name: LegalContentType["name"];
  slug: LegalContentType["slug"];
  heading: LegalContentType["heading"];
  description_unfiltered: LegalContentType["description_unfiltered"];
  is_active: LegalContentType["is_active"];
  created_at: LegalContentType["created_at"];
}) {
  const legalContentToggleStatusMutation =
    useLegalContentToggleStatusMutation(id);

  const onToggle = useCallback(async () => {
    await legalContentToggleStatusMutation.mutateAsync(undefined);
  }, [legalContentToggleStatusMutation]);
  const handleModalEdit = useLegalContentModalStore(
    (state) => state.handleModalEdit,
  );
  const onEditHandler = useCallback(() => {
    handleModalEdit(id);
  }, [id, handleModalEdit]);
  return (
    <tr>
      <td className="px-4 py-3 font-medium text-gray-900">
        <p className="text-sm font-medium text-gray-800">{name}</p>
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
          <LegalContentDeleteBtn id={id} />
        </div>
      </td>
    </tr>
  );
});

function LegalContentTable({ loading, legalContents }: LegalContentTableProps) {
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
          legalContents.map((item) => (
            <LegalContentTableRow
              key={item.id}
              id={item.id}
              name={item.name}
              slug={item.slug}
              heading={item.heading}
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

export default memo(LegalContentTable);
