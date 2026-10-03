import TableRowLoading from "@/components/TableRowLoading";
import type { TaxType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useTaxModalStore } from "../store/tax-modal.store";
import { Button } from "@/components/ui/button";
import { format } from "date-fns";
import TaxDeleteBtn from "./TaxDeleteBtn";
import StatusToggleBadge from "@/components/StatusToggleBadge";
import { useTaxToggleStatusMutation } from "@/utils/data/mutation/tax";
import ActiveBadge from "@/components/ActiveBadge";

type TaxTableProps = {
  taxes: TaxType[];
  loading: boolean;
};

const TaxTableRow = memo(function TaxTableRow({
  id,
  name,
  slug,
  value,
  is_inter_state_tax,
  is_active,
  created_at,
}: {
  id: TaxType["id"];
  name: TaxType["name"];
  slug: TaxType["slug"];
  value: TaxType["value"];
  is_inter_state_tax: TaxType["is_inter_state_tax"];
  is_active: TaxType["is_active"];
  created_at: TaxType["created_at"];
}) {
  const taxToggleStatusMutation = useTaxToggleStatusMutation(id);

  const onToggle = useCallback(async () => {
    await taxToggleStatusMutation.mutateAsync(undefined);
  }, [taxToggleStatusMutation]);
  const handleModalEdit = useTaxModalStore((state) => state.handleModalEdit);
  const onEditHandler = useCallback(() => {
    handleModalEdit(id);
  }, [id, handleModalEdit]);
  return (
    <tr>
      <td className="px-4 py-3 font-medium text-gray-900">
        <p className="text-sm font-medium text-gray-800">{name}</p>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">{slug}</p>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">{`${value}%`}</p>
      </td>
      <td className="px-4 py-3 ">
        <ActiveBadge value={is_inter_state_tax} />
      </td>
      <td className="px-4 py-3 ">
        <StatusToggleBadge
          isActive={is_active}
          onToggle={onToggle}
          loading={taxToggleStatusMutation.isPending}
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
          <TaxDeleteBtn id={id} />
        </div>
      </td>
    </tr>
  );
});

function TaxTable({ loading, taxes }: TaxTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {[
            "Name",
            "Slug",
            "Value",
            "Inter State Tax",
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
          taxes.map((item) => (
            <TaxTableRow
              key={item.id}
              id={item.id}
              name={item.name}
              slug={item.slug}
              value={item.value}
              is_inter_state_tax={item.is_inter_state_tax}
              is_active={item.is_active}
              created_at={item.created_at}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(TaxTable);
