import DeleteButton from "@/components/DeleteButton";
import { useCertificationDeleteMutation } from "@/utils/data/mutation/certification";
import { useCallback } from "react";

function CertificationDeleteBtn({ id }: { id: number }) {
  const certificationDeleteMutation = useCertificationDeleteMutation(id);

  const onDelete = useCallback(async () => {
    await certificationDeleteMutation.mutateAsync(undefined);
  }, [certificationDeleteMutation.mutateAsync]);

  return (
    <DeleteButton
      onDelete={onDelete}
      loading={certificationDeleteMutation.isPending}
    />
  );
}

export default CertificationDeleteBtn;
