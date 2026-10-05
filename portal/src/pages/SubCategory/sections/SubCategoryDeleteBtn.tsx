import { useSubCategoryDeleteMutation } from "@/utils/data/mutation/sub_category";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function SubCategoryDeleteBtn({ id }: { id: number }) {
  const subCategoryDeleteMutation = useSubCategoryDeleteMutation(id);

  const onDelete = useCallback(async () => {
    await subCategoryDeleteMutation.mutateAsync(undefined);
  }, [subCategoryDeleteMutation.mutateAsync]);

  return (
    <DeleteButton
      onDelete={onDelete}
      loading={subCategoryDeleteMutation.isPending}
    />
  );
}

export default SubCategoryDeleteBtn;
