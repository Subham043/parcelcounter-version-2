import TableRowLoading from "@/components/TableRowLoading";
import type { DeliverySlotType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useDeliverySlotModalStore } from "../store/delivery-slot-modal.store";
import { Button } from "@/components/ui/button";
import DeliverySlotDeleteBtn from "./DeliverySlotDeleteBtn";
import StatusToggleBadge from "@/components/StatusToggleBadge";
import { useDeliverySlotToggleStatusMutation } from "@/utils/data/mutation/delivery_slot";
import ActiveBadge from "@/components/ActiveBadge";
import { parse, format } from "date-fns";

type DeliverySlotTableProps = {
  deliverySlots: DeliverySlotType[];
  loading: boolean;
};

const DeliverySlotTableRow = memo(function DeliverySlotTableRow({
  id,
  name,
  start_time,
  end_time,
  is_cod_allowed,
  is_active,
  created_at,
}: {
  id: DeliverySlotType["id"];
  name: DeliverySlotType["name"];
  start_time: DeliverySlotType["start_time"];
  end_time: DeliverySlotType["end_time"];
  is_cod_allowed: DeliverySlotType["is_cod_allowed"];
  is_active: DeliverySlotType["is_active"];
  created_at: DeliverySlotType["created_at"];
}) {
  const deliverySlotToggleStatusMutation =
    useDeliverySlotToggleStatusMutation(id);

  const onToggle = useCallback(async () => {
    await deliverySlotToggleStatusMutation.mutateAsync(undefined);
  }, [deliverySlotToggleStatusMutation]);

  const handleModalEdit = useDeliverySlotModalStore(
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
        <p className="text-sm text-gray-500 truncate">
          {format(
            parse(
              start_time,
              start_time.length === 5 ? "HH:mm" : "HH:mm:ss",
              new Date(),
            ),
            "hh:mm a",
          )}
        </p>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">
          {format(
            parse(
              end_time,
              end_time.length === 5 ? "HH:mm" : "HH:mm:ss",
              new Date(),
            ),
            "hh:mm a",
          )}
        </p>
      </td>
      <td className="px-4 py-3 ">
        <ActiveBadge value={is_cod_allowed} />
      </td>
      <td className="px-4 py-3 ">
        <StatusToggleBadge
          isActive={is_active}
          onToggle={onToggle}
          loading={deliverySlotToggleStatusMutation.isPending}
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
          <DeliverySlotDeleteBtn id={id} />
        </div>
      </td>
    </tr>
  );
});

function DeliverySlotTable({ loading, deliverySlots }: DeliverySlotTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {[
            "Name",
            "Start Time",
            "End Time",
            "COD Allowed",
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
          deliverySlots.map((item) => (
            <DeliverySlotTableRow
              key={item.id}
              id={item.id}
              name={item.name}
              start_time={item.start_time}
              end_time={item.end_time}
              is_cod_allowed={item.is_cod_allowed}
              is_active={item.is_active}
              created_at={item.created_at}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(DeliverySlotTable);
