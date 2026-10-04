import { Button } from "@/components/ui/button";
import { Card, CardHeader } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { Plus, RefreshCw } from "lucide-react";
import type { FeatureType } from "@/utils/types";
import { useFeatureTable } from "./sections/useFeatureTable";
import { useFeatureModalStore } from "./store/feature-modal.store";
import { useEffect } from "react";
import FeatureFilters from "./sections/FeatureFilters";
import FeatureTable from "./sections/FeatureTable";
import EmptyDataBlock from "@/components/EmptyDataBlock";
import CustomPagination from "@/components/CustomPagination";
import FeatureForm from "./FeatureForm";
import FeatureExcelBtn from "./sections/FeatureExcelBtn";

const EMPTY_DATA: FeatureType[] = [];

function Feature() {
  const { data, refetch, isLoading, isFetching } = useFeatureTable();

  const handleModalOpen = useFeatureModalStore(
    (state) => state.handleModalOpen,
  );
  const handleModalClose = useFeatureModalStore(
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
              <h1 className="text-2xl font-bold text-gray-900">Features</h1>
              <p className="text-sm text-gray-500 mt-0.5">
                Features are managed here
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
              <FeatureExcelBtn />
              <Button onClick={handleModalOpen}>
                <Plus size={16} /> Add
              </Button>
            </div>
          </div>
        </CardHeader>
        <div>
          <Separator orientation="horizontal" className="bg-gray-100" />
          <div className="px-4 py-3">
            <FeatureFilters />
          </div>
        </div>
        {(data && data.meta.total > 0) || isLoading || isFetching ? (
          <div className="overflow-x-auto">
            <FeatureTable
              features={data?.data ?? EMPTY_DATA}
              loading={isLoading || isFetching}
            />
            <Separator orientation="horizontal" className="bg-gray-100" />
            {data && data.meta.total > 0 && (
              <CustomPagination totalCount={data ? data.meta.total : 1} />
            )}
          </div>
        ) : (
          <EmptyDataBlock
            title="No Feature Found"
            description="No features are available as of now. Please add now to get started."
          />
        )}
      </Card>
      <FeatureForm />
    </div>
  );
}

export default Feature;
