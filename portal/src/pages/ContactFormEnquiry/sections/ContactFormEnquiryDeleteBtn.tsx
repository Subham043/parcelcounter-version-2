import { useContactFormEnquiryDeleteMutation } from "@/utils/data/mutation/contact_form_enquiry";
import { Button } from "@/components/ui/button";
import { useCallback } from "react";
import { Spinner } from "@/components/ui/spinner";
import { useDeleteConfirmation } from "@/hooks/useDeleteConfirmation";

function ContactFormEnquiryDeleteBtn({ id }: { id: number }) {
  const { handleDeleteModalOpen } = useDeleteConfirmation();
  const contactFormEnquiryDeleteMutation =
    useContactFormEnquiryDeleteMutation(id);

  const onDelete = useCallback(
    () =>
      handleDeleteModalOpen(async () => {
        await contactFormEnquiryDeleteMutation.mutateAsync(undefined);
      }),
    [contactFormEnquiryDeleteMutation.mutateAsync],
  );

  return (
    <Button
      size="xs"
      variant="destructive"
      onClick={onDelete}
      disabled={contactFormEnquiryDeleteMutation.isPending}
    >
      {contactFormEnquiryDeleteMutation.isPending && (
        <Spinner className="size-5" data-icon="inline-start" />
      )}
      {contactFormEnquiryDeleteMutation.isPending ? "Deleting..." : "Delete"}
    </Button>
  );
}

export default ContactFormEnquiryDeleteBtn;
