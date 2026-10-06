import { Button } from "@/components/ui/button";
import { Card, CardHeader } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { Plus, RefreshCw } from "lucide-react";
import type { AboutSectionType } from "@/utils/types";
import { useAboutSectionTable } from "./sections/useAboutSectionTable";
import { useAboutSectionModalStore } from "./store/about-section-modal.store";
import { useEffect } from "react";
import AboutSectionFilters from "./sections/AboutSectionFilters";
import AboutSectionTable from "./sections/AboutSectionTable";
import EmptyDataBlock from "@/components/EmptyDataBlock";
import CustomPagination from "@/components/CustomPagination";
import AboutSectionForm from "./AboutSectionForm";
import AboutSectionExcelBtn from "./sections/AboutSectionExcelBtn";

const EMPTY_DATA: AboutSectionType[] = [];

function AboutSection() {
  const { data, refetch, isLoading, isFetching } = useAboutSectionTable();

  const handleModalOpen = useAboutSectionModalStore(
    (state) => state.handleModalOpen,
  );
  const handleModalClose = useAboutSectionModalStore(
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
                About Sections
              </h1>
              <p className="text-sm text-gray-500 mt-0.5">
                About sections are managed here
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
              <AboutSectionExcelBtn />
              <Button onClick={handleModalOpen}>
                <Plus size={16} /> Add
              </Button>
            </div>
          </div>
        </CardHeader>
        <div>
          <Separator orientation="horizontal" className="bg-gray-100" />
          <div className="px-4 py-3">
            <AboutSectionFilters />
          </div>
        </div>
        {(data && data.meta.total > 0) || isLoading || isFetching ? (
          <div className="overflow-x-auto">
            <AboutSectionTable
              sections={data?.data ?? EMPTY_DATA}
              loading={isLoading || isFetching}
            />
            <Separator orientation="horizontal" className="bg-gray-100" />
            {data && data.meta.total > 0 && (
              <CustomPagination totalCount={data ? data.meta.total : 1} />
            )}
          </div>
        ) : (
          <EmptyDataBlock
            title="No About Section Found"
            description="No sections are available as of now. Please add now to get started."
          />
        )}
      </Card>
      <AboutSectionForm />
    </div>
  );
}

export default AboutSection;
