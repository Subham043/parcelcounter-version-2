import { useTestimonialDeleteMutation } from "@/utils/data/mutation/testimonial";
import { Button } from "@/components/ui/button";
import { useCallback } from "react";
import { Spinner } from "@/components/ui/spinner";
import { useDeleteConfirmation } from "@/hooks/useDeleteConfirmation";

function TestimonialDeleteBtn({ id }: { id: number }) {
  const { handleDeleteModalOpen } = useDeleteConfirmation();
  const testimonialDeleteMutation = useTestimonialDeleteMutation(id);

  const onDelete = useCallback(
    () =>
      handleDeleteModalOpen(async () => {
        await testimonialDeleteMutation.mutateAsync(undefined);
      }),
    [testimonialDeleteMutation.mutateAsync],
  );

  return (
    <Button
      size="xs"
      variant="destructive"
      onClick={onDelete}
      disabled={testimonialDeleteMutation.isPending}
    >
      {testimonialDeleteMutation.isPending && (
        <Spinner className="size-5" data-icon="inline-start" />
      )}
      {testimonialDeleteMutation.isPending ? "Deleting..." : "Delete"}
    </Button>
  );
}

export default TestimonialDeleteBtn;
