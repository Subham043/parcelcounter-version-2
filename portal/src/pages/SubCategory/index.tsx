import { Button } from "@/components/ui/button";
import { Card, CardHeader } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { Plus, RefreshCw } from "lucide-react";
import type { SubCategoryType } from "@/utils/types";
import { useSubCategoryTable } from "./sections/useSubCategoryTable";
import { useSubCategoryModalStore } from "./store/sub-category-modal.store";
import { useEffect } from "react";
import SubCategoryFilters from "./sections/SubCategoryFilters";
import SubCategoryTable from "./sections/SubCategoryTable";
import EmptyDataBlock from "@/components/EmptyDataBlock";
import CustomPagination from "@/components/CustomPagination";
import SubCategoryForm from "./SubCategoryForm";
import SubCategoryExcelBtn from "./sections/SubCategoryExcelBtn";

const EMPTY_DATA: SubCategoryType[] = [];

function SubCategory() {
  const { data, refetch, isLoading, isFetching } = useSubCategoryTable();

  const handleModalOpen = useSubCategoryModalStore(
    (state) => state.handleModalOpen,
  );
  const handleModalClose = useSubCategoryModalStore(
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
                Sub-Categories
              </h1>
              <p className="text-sm text-gray-500 mt-0.5">
                Sub-Categories are managed here
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
              <SubCategoryExcelBtn />
              <Button onClick={handleModalOpen}>
                <Plus size={16} /> Add
              </Button>
            </div>
          </div>
        </CardHeader>
        <div>
          <Separator orientation="horizontal" className="bg-gray-100" />
          <div className="px-4 py-3">
            <SubCategoryFilters />
          </div>
        </div>
        {(data && data.meta.total > 0) || isLoading || isFetching ? (
          <div className="overflow-x-auto">
            <SubCategoryTable
              subCategories={data?.data ?? EMPTY_DATA}
              loading={isLoading || isFetching}
            />
            <Separator orientation="horizontal" className="bg-gray-100" />
            {data && data.meta.total > 0 && (
              <CustomPagination totalCount={data ? data.meta.total : 1} />
            )}
          </div>
        ) : (
          <EmptyDataBlock
            title="No Sub-Category Found"
            description="No sub-categories are available as of now. Please add now to get started."
          />
        )}
      </Card>
      <SubCategoryForm />
    </div>
  );
}

export default SubCategory;
