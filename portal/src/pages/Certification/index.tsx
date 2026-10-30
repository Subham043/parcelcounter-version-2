import { Button } from "@/components/ui/button";
import { Card, CardHeader } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { Plus, RefreshCw } from "lucide-react";
import type { CertificationType } from "@/utils/types";
import { useCertificationTable } from "./sections/useCertificationTable";
import { useCertificationModalStore } from "./store/certification-modal.store";
import { useEffect } from "react";
import CertificationFilters from "./sections/CertificationFilters";
import CertificationTable from "./sections/CertificationTable";
import EmptyDataBlock from "@/components/EmptyDataBlock";
import CustomPagination from "@/components/CustomPagination";
import CertificationForm from "./CertificationForm";
import CertificationExcelBtn from "./sections/CertificationExcelBtn";

const EMPTY_DATA: CertificationType[] = [];

function Certification() {
  const { data, refetch, isLoading, isFetching } = useCertificationTable();

  const handleModalOpen = useCertificationModalStore(
    (state) => state.handleModalOpen,
  );
  const handleModalClose = useCertificationModalStore(
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
                Certifications
              </h1>
              <p className="text-sm text-gray-500 mt-0.5">
                Certifications are managed here
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
              <CertificationExcelBtn />
              <Button onClick={handleModalOpen}>
                <Plus size={16} /> Add
              </Button>
            </div>
          </div>
        </CardHeader>
        <div>
          <Separator orientation="horizontal" className="bg-gray-100" />
          <div className="px-4 py-3">
            <CertificationFilters />
          </div>
        </div>
        {(data && data.meta.total > 0) || isLoading || isFetching ? (
          <div className="overflow-x-auto">
            <CertificationTable
              certifications={data?.data ?? EMPTY_DATA}
              loading={isLoading || isFetching}
            />
            <Separator orientation="horizontal" className="bg-gray-100" />
            {data && data.meta.total > 0 && (
              <CustomPagination totalCount={data ? data.meta.total : 1} />
            )}
          </div>
        ) : (
          <EmptyDataBlock
            title="No Certification Found"
            description="No certifications are available as of now. Please add now to get started."
          />
        )}
      </Card>
      <CertificationForm />
    </div>
  );
}

export default Certification;
