import { Button } from "@/components/ui/button";
import { Card, CardHeader } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { Plus, RefreshCw } from "lucide-react";
import type { BannerType } from "@/utils/types";
import { useBannerTable } from "./sections/useBannerTable";
import { useBannerModalStore } from "./store/banner-modal.store";
import { useEffect } from "react";
import BannerFilters from "./sections/BannerFilters";
import BannerTable from "./sections/BannerTable";
import EmptyDataBlock from "@/components/EmptyDataBlock";
import CustomPagination from "@/components/CustomPagination";
import BannerForm from "./BannerForm";

const EMPTY_DATA: BannerType[] = [];

function Banner() {
  const { data, refetch, isLoading, isFetching } = useBannerTable();

  const handleModalOpen = useBannerModalStore((state) => state.handleModalOpen);
  const handleModalClose = useBannerModalStore(
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
              <h1 className="text-2xl font-bold text-gray-900">Banners</h1>
              <p className="text-sm text-gray-500 mt-0.5">
                Banners are managed here
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
              <Button onClick={handleModalOpen}>
                <Plus size={16} /> Add
              </Button>
            </div>
          </div>
        </CardHeader>
        <div>
          <Separator orientation="horizontal" className="bg-gray-100" />
          <div className="px-4 py-3">
            <BannerFilters />
          </div>
        </div>
        {(data && data.meta.total > 0) || isLoading || isFetching ? (
          <div className="overflow-x-auto">
            <BannerTable
              banners={data?.data ?? EMPTY_DATA}
              loading={isLoading || isFetching}
            />
            <Separator orientation="horizontal" className="bg-gray-100" />
            {data && data.meta.total > 0 && (
              <CustomPagination totalCount={data ? data.meta.total : 1} />
            )}
          </div>
        ) : (
          <EmptyDataBlock
            title="No Banner Found"
            description="No banners are available as of now. Please add now to get started."
          />
        )}
      </Card>
      <BannerForm />
    </div>
  );
}

export default Banner;
