import { useCategoryDeleteMutation } from "@/utils/data/mutation/category";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function CategoryDeleteBtn({ id }: { id: number }) {
  const categoryDeleteMutation = useCategoryDeleteMutation(id);

  const onDelete = useCallback(async () => {
    await categoryDeleteMutation.mutateAsync(undefined);
  }, [categoryDeleteMutation.mutateAsync]);

  return (
    <DeleteButton
      onDelete={onDelete}
      loading={categoryDeleteMutation.isPending}
    />
  );
}

export default CategoryDeleteBtn;
