import { useChargeDeleteMutation } from "@/utils/data/mutation/charge";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function ChargeDeleteBtn({ id }: { id: number }) {
  const chargeDeleteMutation = useChargeDeleteMutation(id);

  const onDelete = useCallback(async () => {
    await chargeDeleteMutation.mutateAsync(undefined);
  }, [chargeDeleteMutation.mutateAsync]);

  return (
    <DeleteButton
      onDelete={onDelete}
      loading={chargeDeleteMutation.isPending}
    />
  );
}

export default ChargeDeleteBtn;
