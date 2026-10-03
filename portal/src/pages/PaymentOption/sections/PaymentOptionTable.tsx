import TableRowLoading from "@/components/TableRowLoading";
import type { PaymentOptionType } from "@/utils/types";
import { memo, useCallback } from "react";
import { format } from "date-fns";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { getNameInitials } from "@/utils/helper";
import { usePaymentOptionToggleStatusMutation } from "@/utils/data/mutation/payment_option";
import StatusToggleBadge from "@/components/StatusToggleBadge";

type PaymentOptionTableProps = {
  options: PaymentOptionType[];
  loading: boolean;
};

const PaymentOptionTableRow = memo(function PaymentOptionTableRow({
  id,
  name,
  slug,
  description,
  image_url,
  is_active,
  created_at,
}: {
  id: PaymentOptionType["id"];
  name: PaymentOptionType["name"];
  slug: PaymentOptionType["slug"];
  description: PaymentOptionType["description"];
  image_url: PaymentOptionType["image_url"];
  is_active: PaymentOptionType["is_active"];
  created_at: PaymentOptionType["created_at"];
}) {
  const paymentOptionToggleStatusMutation =
    usePaymentOptionToggleStatusMutation(id);

  const onToggle = useCallback(async () => {
    await paymentOptionToggleStatusMutation.mutateAsync(undefined);
  }, [paymentOptionToggleStatusMutation]);
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
        <p className="text-sm text-gray-500 truncate">{description}</p>
      </td>
      <td className="px-4 py-3 ">
        <StatusToggleBadge
          isActive={is_active}
          onToggle={onToggle}
          loading={paymentOptionToggleStatusMutation.isPending}
        />
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">
          {format(created_at, "dd MMM yyyy, hh:mm a")}
        </p>
      </td>
    </tr>
  );
});

function PaymentOptionTable({ loading, options }: PaymentOptionTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {["Name", "Slug", "Description", "Active", "Created At"].map((h) => (
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
          options.map((item) => (
            <PaymentOptionTableRow
              key={item.id}
              id={item.id}
              name={item.name}
              slug={item.slug}
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

export default memo(PaymentOptionTable);
