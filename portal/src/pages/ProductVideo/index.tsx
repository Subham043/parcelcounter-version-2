import { Button } from "@/components/ui/button";
import { Card, CardHeader } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { Plus, RefreshCw } from "lucide-react";
import type { ProductVideoType } from "@/utils/types";
import { useProductVideoTable } from "./sections/useProductVideoTable";
import { useProductVideoModalStore } from "./store/product-video-modal.store";
import { useEffect } from "react";
import ProductVideoFilters from "./sections/ProductVideoFilters";
import ProductVideoTable from "./sections/ProductVideoTable";
import EmptyDataBlock from "@/components/EmptyDataBlock";
import CustomPagination from "@/components/CustomPagination";
import ProductVideoForm from "./ProductVideoForm";

const EMPTY_DATA: ProductVideoType[] = [];

function ProductVideo() {
  const { data, refetch, isLoading, isFetching, product_id } =
    useProductVideoTable();

  const handleModalOpen = useProductVideoModalStore(
    (state) => state.handleModalOpen,
  );
  const handleModalClose = useProductVideoModalStore(
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
                Product Videos
              </h1>
              <p className="text-sm text-gray-500 mt-0.5">
                Product videos are managed here
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
            <ProductVideoFilters />
          </div>
        </div>
        {(data && data.meta.total > 0) || isLoading || isFetching ? (
          <div className="overflow-x-auto">
            <ProductVideoTable
              videos={data?.data ?? EMPTY_DATA}
              loading={isLoading || isFetching}
              product_id={product_id}
            />
            <Separator orientation="horizontal" className="bg-gray-100" />
            {data && data.meta.total > 0 && (
              <CustomPagination totalCount={data ? data.meta.total : 1} />
            )}
          </div>
        ) : (
          <EmptyDataBlock
            title="No Product Video Found"
            description="No videos are available as of now. Please add now to get started."
          />
        )}
      </Card>
      <ProductVideoForm product_id={product_id} />
    </div>
  );
}

export default ProductVideo;
