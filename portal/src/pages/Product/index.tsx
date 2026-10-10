import { Button } from "@/components/ui/button";
import { Card, CardHeader } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { Plus, RefreshCw } from "lucide-react";
import type { ProductType } from "@/utils/types";
import { useProductTable } from "./sections/useProductTable";
import ProductFilters from "./sections/ProductFilters";
import ProductTable from "./sections/ProductTable";
import EmptyDataBlock from "@/components/EmptyDataBlock";
import CustomPagination from "@/components/CustomPagination";
import ProductExcelBtn from "./sections/ProductExcelBtn";
import { Link } from "react-router";
import { page_routes } from "@/utils/routes/page_routes";

const EMPTY_DATA: ProductType[] = [];

function Product() {
  const { data, refetch, isLoading, isFetching } = useProductTable();

  return (
    <div className="space-y-6 pt-5">
      <Card className="rounded-sm py-0 gap-0">
        <CardHeader className="px-4 py-3">
          <div className="flex items-end justify-between gap-4">
            <div>
              <h1 className="text-2xl font-bold text-gray-900">Products</h1>
              <p className="text-sm text-gray-500 mt-0.5">
                Products are managed here
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
              <ProductExcelBtn />
              <Button
                nativeButton={false}
                render={<Link to={page_routes.add_product.link} />}
              >
                <Plus size={16} /> Add
              </Button>
            </div>
          </div>
        </CardHeader>
        <div>
          <Separator orientation="horizontal" className="bg-gray-100" />
          <div className="px-4 py-3">
            <ProductFilters />
          </div>
        </div>
        {(data && data.meta.total > 0) || isLoading || isFetching ? (
          <div className="overflow-x-auto">
            <ProductTable
              products={data?.data ?? EMPTY_DATA}
              loading={isLoading || isFetching}
            />
            <Separator orientation="horizontal" className="bg-gray-100" />
            {data && data.meta.total > 0 && (
              <CustomPagination totalCount={data ? data.meta.total : 1} />
            )}
          </div>
        ) : (
          <EmptyDataBlock
            title="No Product Found"
            description="No products are available as of now. Please add now to get started."
          />
        )}
      </Card>
    </div>
  );
}

export default Product;
