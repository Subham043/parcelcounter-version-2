import { Button } from "@/components/ui/button";
import { Card, CardHeader } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { RefreshCw } from "lucide-react";
import type { ContactFormEnquiryType } from "@/utils/types";
import { useContactFormEnquiryTable } from "./sections/useContactFormEnquiryTable";
import { useContactFormEnquiryModalStore } from "./store/contact-form-enquiry-modal.store";
import { useEffect } from "react";
import ContactFormEnquiryFilters from "./sections/ContactFormEnquiryFilters";
import ContactFormEnquiryTable from "./sections/ContactFormEnquiryTable";
import EmptyDataBlock from "@/components/EmptyDataBlock";
import CustomPagination from "@/components/CustomPagination";
import ContactFormEnquiryForm from "./ContactFormEnquiryForm";

const EMPTY_DATA: ContactFormEnquiryType[] = [];

function ContactFormEnquiry() {
  const { data, refetch, isLoading, isFetching } = useContactFormEnquiryTable();

  const handleModalClose = useContactFormEnquiryModalStore(
    (state) => state.handleModalClose,
  );

  useEffect(() => {
    return () => {
      handleModalClose();
    };
  }, [handleModalClose]);

  return (
    <div className="space-y-6 pt-5">
      <Card className="rounded-sm py-0 gap-0">
        <CardHeader className="px-4 py-3">
          <div className="flex items-end justify-between gap-4">
            <div>
              <h1 className="text-2xl font-bold text-gray-900">
                Contact Form Enquiries
              </h1>
              <p className="text-sm text-gray-500 mt-0.5">
                Enquiries are managed here
              </p>
            </div>
            <div className="flex items-center gap-2">
              <Button
                size="sm"
                variant="ghost"
                title="Refresh"
                disabled={isLoading || isFetching}
                onClick={() => refetch()}
              >
                <RefreshCw size={14} />
              </Button>
            </div>
          </div>
        </CardHeader>
        <div>
          <Separator orientation="horizontal" className="bg-gray-100" />
          <div className="px-4 py-3">
            <ContactFormEnquiryFilters />
          </div>
        </div>
        {(data && data.meta.total > 0) || isLoading || isFetching ? (
          <div className="overflow-x-auto">
            <ContactFormEnquiryTable
              enquiries={data?.data ?? EMPTY_DATA}
              loading={isLoading || isFetching}
            />
            <Separator orientation="horizontal" className="bg-gray-100" />
            {data && data.meta.total > 0 && (
              <CustomPagination totalCount={data ? data.meta.total : 1} />
            )}
          </div>
        ) : (
          <EmptyDataBlock
            title="No Enquiry Found"
            description="No enquiries are available as of now."
          />
        )}
      </Card>
      <ContactFormEnquiryForm />
    </div>
  );
}

export default ContactFormEnquiry;
