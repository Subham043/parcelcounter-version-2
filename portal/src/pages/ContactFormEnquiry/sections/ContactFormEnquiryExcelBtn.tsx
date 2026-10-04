import { useContactFormEnquiryExportMutation } from "@/utils/data/mutation/contact_form_enquiry";
import { useCallback } from "react";
import ExcelExportButton from "@/components/ExcelExportButton";

function ContactFormEnquiryExcelBtn() {
  const contactFormEnquiryExportMutation =
    useContactFormEnquiryExportMutation();

  const onExport = useCallback(async () => {
    await contactFormEnquiryExportMutation.mutateAsync(undefined);
  }, [contactFormEnquiryExportMutation.mutateAsync]);

  return (
    <ExcelExportButton
      loading={contactFormEnquiryExportMutation.isPending}
      onExport={onExport}
    />
  );
}

export default ContactFormEnquiryExcelBtn;
