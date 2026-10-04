import { useTestimonialExportMutation } from "@/utils/data/mutation/testimonial";
import { useCallback } from "react";
import ExcelExportButton from "@/components/ExcelExportButton";

function TestimonialExcelBtn() {
  const testimonialExportMutation = useTestimonialExportMutation();

  const onExport = useCallback(async () => {
    await testimonialExportMutation.mutateAsync(undefined);
  }, [testimonialExportMutation.mutateAsync]);

  return (
    <ExcelExportButton
      loading={testimonialExportMutation.isPending}
      onExport={onExport}
    />
  );
}

export default TestimonialExcelBtn;
