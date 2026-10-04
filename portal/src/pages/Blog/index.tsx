import { Button } from "@/components/ui/button";
import { Card, CardHeader } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { Plus, RefreshCw } from "lucide-react";
import type { BlogType } from "@/utils/types";
import { useBlogTable } from "./sections/useBlogTable";
import { useBlogModalStore } from "./store/blog-modal.store";
import { useEffect } from "react";
import BlogFilters from "./sections/BlogFilters";
import BlogTable from "./sections/BlogTable";
import EmptyDataBlock from "@/components/EmptyDataBlock";
import CustomPagination from "@/components/CustomPagination";
import BlogForm from "./BlogForm";
import BlogExcelBtn from "./sections/BlogExcelBtn";

const EMPTY_DATA: BlogType[] = [];

function Blog() {
  const { data, refetch, isLoading, isFetching } = useBlogTable();

  const handleModalOpen = useBlogModalStore((state) => state.handleModalOpen);
  const handleModalClose = useBlogModalStore((state) => state.handleModalClose);

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
              <h1 className="text-2xl font-bold text-gray-900">Blogs</h1>
              <p className="text-sm text-gray-500 mt-0.5">
                Blogs are managed here
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
              <BlogExcelBtn />
              <Button onClick={handleModalOpen}>
                <Plus size={16} /> Add
              </Button>
            </div>
          </div>
        </CardHeader>
        <div>
          <Separator orientation="horizontal" className="bg-gray-100" />
          <div className="px-4 py-3">
            <BlogFilters />
          </div>
        </div>
        {(data && data.meta.total > 0) || isLoading || isFetching ? (
          <div className="overflow-x-auto">
            <BlogTable
              blogs={data?.data ?? EMPTY_DATA}
              loading={isLoading || isFetching}
            />
            <Separator orientation="horizontal" className="bg-gray-100" />
            {data && data.meta.total > 0 && (
              <CustomPagination totalCount={data ? data.meta.total : 1} />
            )}
          </div>
        ) : (
          <EmptyDataBlock
            title="No Blog Found"
            description="No blogs are available as of now. Please add now to get started."
          />
        )}
      </Card>
      <BlogForm />
    </div>
  );
}

export default Blog;
