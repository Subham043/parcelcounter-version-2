import { useBlogDeleteMutation } from "@/utils/data/mutation/blog";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function BlogDeleteBtn({ id }: { id: number }) {
  const blogDeleteMutation = useBlogDeleteMutation(id);

  const onDelete = useCallback(async () => {
    await blogDeleteMutation.mutateAsync(undefined);
  }, [blogDeleteMutation.mutateAsync]);

  return (
    <DeleteButton onDelete={onDelete} loading={blogDeleteMutation.isPending} />
  );
}

export default BlogDeleteBtn;
