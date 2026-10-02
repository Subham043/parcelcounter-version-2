import TableRowLoading from "@/components/TableRowLoading";
import type { ChargeType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useChargeModalStore } from "../store/charge-modal.store";
import { Button } from "@/components/ui/button";
import { format } from "date-fns";
import ChargeDeleteBtn from "./ChargeDeleteBtn";
import ChargeStatusToggle from "./ChargeStatusToggle";

type ChargeTableProps = {
  charges: ChargeType[];
  loading: boolean;
};

const ChargeTableRow = memo(function ChargeTableRow({
  id,
  name,
  slug,
  value,
  is_percentage,
  is_active,
  created_at,
}: {
  id: ChargeType["id"];
  name: ChargeType["name"];
  slug: ChargeType["slug"];
  value: ChargeType["value"];
  is_percentage: ChargeType["is_percentage"];
  is_active: ChargeType["is_active"];
  created_at: ChargeType["created_at"];
}) {
  const handleModalEdit = useChargeModalStore((state) => state.handleModalEdit);
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
        <p className="text-sm text-gray-500 truncate">
          {is_percentage ? `${value}%` : `₹${value}`}
        </p>
      </td>
      <td className="px-4 py-3 ">
        <ChargeStatusToggle id={id} isActive={is_active} />
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
          <ChargeDeleteBtn id={id} />
        </div>
      </td>
    </tr>
  );
});

function ChargeTable({ loading, charges }: ChargeTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {["Name", "Slug", "Value", "Is Active", "Created At", ""].map((h) => (
            <th key={h} className="px-4 py-3 text-left font-medium">
              {h}
            </th>
          ))}
        </tr>
      </thead>
      <tbody className="divide-y divide-gray-100">
        {loading ? (
          <TableRowLoading colSpan={6} />
        ) : (
          charges.map((item) => (
            <ChargeTableRow
              key={item.id}
              id={item.id}
              name={item.name}
              slug={item.slug}
              value={item.value}
              is_percentage={item.is_percentage}
              is_active={item.is_active}
              created_at={item.created_at}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(ChargeTable);
