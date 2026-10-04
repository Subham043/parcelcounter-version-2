import { Button } from "@/components/ui/button";
import { Card, CardHeader } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { Plus, RefreshCw } from "lucide-react";
import type { CategoryType } from "@/utils/types";
import { useCategoryTable } from "./sections/useCategoryTable";
import { useCategoryModalStore } from "./store/category-modal.store";
import { useEffect } from "react";
import CategoryFilters from "./sections/CategoryFilters";
import CategoryTable from "./sections/CategoryTable";
import EmptyDataBlock from "@/components/EmptyDataBlock";
import CustomPagination from "@/components/CustomPagination";
import CategoryForm from "./CategoryForm";
import CategoryExcelBtn from "./sections/CategoryExcelBtn";

const EMPTY_DATA: CategoryType[] = [];

function Category() {
  const { data, refetch, isLoading, isFetching } = useCategoryTable();

  const handleModalOpen = useCategoryModalStore(
    (state) => state.handleModalOpen,
  );
  const handleModalClose = useCategoryModalStore(
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
              <h1 className="text-2xl font-bold text-gray-900">Categories</h1>
              <p className="text-sm text-gray-500 mt-0.5">
                Categories are managed here
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
              <CategoryExcelBtn />
              <Button onClick={handleModalOpen}>
                <Plus size={16} /> Add
              </Button>
            </div>
          </div>
        </CardHeader>
        <div>
          <Separator orientation="horizontal" className="bg-gray-100" />
          <div className="px-4 py-3">
            <CategoryFilters />
          </div>
        </div>
        {(data && data.meta.total > 0) || isLoading || isFetching ? (
          <div className="overflow-x-auto">
            <CategoryTable
              categories={data?.data ?? EMPTY_DATA}
              loading={isLoading || isFetching}
            />
            <Separator orientation="horizontal" className="bg-gray-100" />
            {data && data.meta.total > 0 && (
              <CustomPagination totalCount={data ? data.meta.total : 1} />
            )}
          </div>
        ) : (
          <EmptyDataBlock
            title="No Category Found"
            description="No categories are available as of now. Please add now to get started."
          />
        )}
      </Card>
      <CategoryForm />
    </div>
  );
}

export default Category;
