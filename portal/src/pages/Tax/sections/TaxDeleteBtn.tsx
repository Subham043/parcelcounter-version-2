import { useTaxDeleteMutation } from "@/utils/data/mutation/tax";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function TaxDeleteBtn({ id }: { id: number }) {
  const taxDeleteMutation = useTaxDeleteMutation(id);

  const onDelete = useCallback(async () => {
    await taxDeleteMutation.mutateAsync(undefined);
  }, [taxDeleteMutation.mutateAsync]);

  return (
    <DeleteButton onDelete={onDelete} loading={taxDeleteMutation.isPending} />
  );
}

export default TaxDeleteBtn;
