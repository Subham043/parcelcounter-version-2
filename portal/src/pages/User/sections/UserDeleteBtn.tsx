import { useUserDeleteMutation } from "@/utils/data/mutation/user";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function UserDeleteBtn({ id }: { id: number }) {
  const userDeleteMutation = useUserDeleteMutation(id);

  const onDelete = useCallback(async () => {
    await userDeleteMutation.mutateAsync(undefined);
  }, [userDeleteMutation.mutateAsync]);

  return (
    <DeleteButton onDelete={onDelete} loading={userDeleteMutation.isPending} />
  );
}

export default UserDeleteBtn;
