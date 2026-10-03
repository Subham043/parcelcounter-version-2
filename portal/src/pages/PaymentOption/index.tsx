import { Button } from "@/components/ui/button";
import { Card, CardHeader } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { RefreshCw } from "lucide-react";
import type { PaymentOptionType } from "@/utils/types";
import { usePaymentOptionTable } from "./sections/usePaymentOptionTable";
import PaymentOptionFilters from "./sections/PaymentOptionFilters";
import PaymentOptionTable from "./sections/PaymentOptionTable";
import EmptyDataBlock from "@/components/EmptyDataBlock";
import CustomPagination from "@/components/CustomPagination";

const EMPTY_DATA: PaymentOptionType[] = [];

function PaymentOption() {
  const { data, refetch, isLoading, isFetching } = usePaymentOptionTable();

  return (
    <div className="space-y-6 pt-5">
      <Card className="rounded-sm py-0 gap-0">
        <CardHeader className="px-4 py-3">
          <div className="flex items-end justify-between gap-4">
            <div>
              <h1 className="text-2xl font-bold text-gray-900">
                Payment Options
              </h1>
              <p className="text-sm text-gray-500 mt-0.5">
                Payment options are managed here
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
            </div>
          </div>
        </CardHeader>
        <div>
          <Separator orientation="horizontal" className="bg-gray-100" />
          <div className="px-4 py-3">
            <PaymentOptionFilters />
          </div>
        </div>
        {(data && data.meta.total > 0) || isLoading || isFetching ? (
          <div className="overflow-x-auto">
            <PaymentOptionTable
              options={data?.data ?? EMPTY_DATA}
              loading={isLoading || isFetching}
            />
            <Separator orientation="horizontal" className="bg-gray-100" />
            {data && data.meta.total > 0 && (
              <CustomPagination totalCount={data ? data.meta.total : 1} />
            )}
          </div>
        ) : (
          <EmptyDataBlock
            title="No Payment Option Found"
            description="No payment options are available as of now."
          />
        )}
      </Card>
    </div>
  );
}

export default PaymentOption;
