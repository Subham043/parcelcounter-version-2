import { Button } from "@/components/ui/button";
import { Card, CardHeader } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { Plus, RefreshCw } from "lucide-react";
import type { ProductColorType } from "@/utils/types";
import { useProductColorTable } from "./sections/useProductColorTable";
import { useProductColorModalStore } from "./store/product-color-modal.store";
import { useEffect } from "react";
import ProductColorFilters from "./sections/ProductColorFilters";
import ProductColorTable from "./sections/ProductColorTable";
import EmptyDataBlock from "@/components/EmptyDataBlock";
import CustomPagination from "@/components/CustomPagination";
import ProductColorForm from "./ProductColorForm";

const EMPTY_DATA: ProductColorType[] = [];

function ProductColor() {
  const { data, refetch, isLoading, isFetching, product_id } =
    useProductColorTable();

  const handleModalOpen = useProductColorModalStore(
    (state) => state.handleModalOpen,
  );
  const handleModalClose = useProductColorModalStore(
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
                Product Colors
              </h1>
              <p className="text-sm text-gray-500 mt-0.5">
                Product colors are managed here
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
            <ProductColorFilters />
          </div>
        </div>
        {(data && data.meta.total > 0) || isLoading || isFetching ? (
          <div className="overflow-x-auto">
            <ProductColorTable
              colors={data?.data ?? EMPTY_DATA}
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
            title="No Product Color Found"
            description="No colors are available as of now. Please add now to get started."
          />
        )}
      </Card>
      <ProductColorForm product_id={product_id} />
    </div>
  );
}

export default ProductColor;
