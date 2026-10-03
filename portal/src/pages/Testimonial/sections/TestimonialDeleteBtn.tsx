import { useTestimonialDeleteMutation } from "@/utils/data/mutation/testimonial";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function TestimonialDeleteBtn({ id }: { id: number }) {
  const testimonialDeleteMutation = useTestimonialDeleteMutation(id);

  const onDelete = useCallback(async () => {
    await testimonialDeleteMutation.mutateAsync(undefined);
  }, [testimonialDeleteMutation.mutateAsync]);

  return (
    <DeleteButton
      onDelete={onDelete}
      loading={testimonialDeleteMutation.isPending}
    />
  );
}

export default TestimonialDeleteBtn;
