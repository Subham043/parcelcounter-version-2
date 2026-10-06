import TableRowLoading from "@/components/TableRowLoading";
import type { UserType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useUserModalStore } from "../store/user-modal.store";
import { Button } from "@/components/ui/button";
import { format } from "date-fns";
import UserDeleteBtn from "./UserDeleteBtn";
import {
  useUserToggleStatusMutation,
  useUserToggleVerificationMutation,
} from "@/utils/data/mutation/user";
import StatusToggleBadge from "@/components/StatusToggleBadge";
import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import { getNameInitials } from "@/utils/helper";

type UserTableProps = {
  users: UserType[];
  loading: boolean;
};

const UserTableRow = memo(function UserTableRow({
  id,
  name,
  email,
  phone,
  is_blocked,
  verified,
  roles,
  created_at,
}: {
  id: UserType["id"];
  name: UserType["name"];
  email: UserType["email"];
  phone: UserType["phone"];
  is_blocked: UserType["is_blocked"];
  verified: UserType["verified"];
  roles: UserType["roles"];
  created_at: UserType["created_at"];
}) {
  const userToggleStatusMutation = useUserToggleStatusMutation(id);
  const onStatusToggle = useCallback(async () => {
    await userToggleStatusMutation.mutateAsync(undefined);
  }, [userToggleStatusMutation]);

  const userToggleVerificationMutation = useUserToggleVerificationMutation(id);
  const onVerificationToggle = useCallback(async () => {
    await userToggleVerificationMutation.mutateAsync(undefined);
  }, [userToggleVerificationMutation]);

  const handleModalEdit = useUserModalStore((state) => state.handleModalEdit);
  const onEditHandler = useCallback(() => {
    handleModalEdit(id);
  }, [id, handleModalEdit]);

  return (
    <tr>
      <td className="px-4 py-3 font-medium text-gray-900">
        <div className="flex items-center gap-2 py-1 ">
          <Avatar className="h-8 w-8 rounded-lg">
            <AvatarFallback className="rounded-lg">
              {getNameInitials(name)}
            </AvatarFallback>
          </Avatar>
          <div className="px-1">
            <p className="text-sm font-medium text-gray-800">{name}</p>
            <p className="text-xs text-gray-500">{phone}</p>
          </div>
        </div>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500">{email ?? "-"}</p>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500">
          {roles.map((item) => item.name).join(", ")}
        </p>
      </td>
      <td className="px-4 py-3 ">
        <StatusToggleBadge
          isActive={verified === "VERIFIED"}
          onToggle={onVerificationToggle}
          loading={userToggleVerificationMutation.isPending}
        />
      </td>
      <td className="px-4 py-3 ">
        <StatusToggleBadge
          isActive={is_blocked === false}
          onToggle={onStatusToggle}
          loading={userToggleStatusMutation.isPending}
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
          <UserDeleteBtn id={id} />
        </div>
      </td>
    </tr>
  );
});

function UserTable({ loading, users }: UserTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {[
            "Profile",
            "Email",
            "Role",
            "Verified",
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
          users.map((item) => (
            <UserTableRow
              key={item.id}
              id={item.id}
              name={item.name}
              email={item.email}
              phone={item.phone}
              roles={item.roles}
              verified={item.verified}
              is_blocked={item.is_blocked}
              created_at={item.created_at}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(UserTable);
