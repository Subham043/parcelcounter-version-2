import { useFeatureDeleteMutation } from "@/utils/data/mutation/feature";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function FeatureDeleteBtn({ id }: { id: number }) {
  const featureDeleteMutation = useFeatureDeleteMutation(id);

  const onDelete = useCallback(async () => {
    await featureDeleteMutation.mutateAsync(undefined);
  }, [featureDeleteMutation.mutateAsync]);

  return (
    <DeleteButton
      onDelete={onDelete}
      loading={featureDeleteMutation.isPending}
    />
  );
}

export default FeatureDeleteBtn;
