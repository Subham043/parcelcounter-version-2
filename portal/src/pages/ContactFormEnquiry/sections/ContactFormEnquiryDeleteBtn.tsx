import { useContactFormEnquiryDeleteMutation } from "@/utils/data/mutation/contact_form_enquiry";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function ContactFormEnquiryDeleteBtn({ id }: { id: number }) {
  const contactFormEnquiryDeleteMutation =
    useContactFormEnquiryDeleteMutation(id);

  const onDelete = useCallback(async () => {
    await contactFormEnquiryDeleteMutation.mutateAsync(undefined);
  }, [contactFormEnquiryDeleteMutation.mutateAsync]);

  return (
    <DeleteButton
      onDelete={onDelete}
      loading={contactFormEnquiryDeleteMutation.isPending}
    />
  );
}

export default ContactFormEnquiryDeleteBtn;
