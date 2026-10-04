import { useLegalContentDeleteMutation } from "@/utils/data/mutation/legal_content";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function LegalContentDeleteBtn({ id }: { id: number }) {
  const legalContentDeleteMutation = useLegalContentDeleteMutation(id);

  const onDelete = useCallback(async () => {
    await legalContentDeleteMutation.mutateAsync(undefined);
  }, [legalContentDeleteMutation.mutateAsync]);

  return (
    <DeleteButton
      onDelete={onDelete}
      loading={legalContentDeleteMutation.isPending}
    />
  );
}

export default LegalContentDeleteBtn;
