import { Button } from "@/components/ui/button";
import { Card, CardHeader } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { Plus, RefreshCw } from "lucide-react";
import type { DeliverySlotType } from "@/utils/types";
import { useDeliverySlotTable } from "./sections/useDeliverySlotTable";
import { useDeliverySlotModalStore } from "./store/delivery-slot-modal.store";
import { useEffect } from "react";
import DeliverySlotFilters from "./sections/DeliverySlotFilters";
import DeliverySlotTable from "./sections/DeliverySlotTable";
import EmptyDataBlock from "@/components/EmptyDataBlock";
import CustomPagination from "@/components/CustomPagination";
import DeliverySlotForm from "./DeliverySlotForm";
import DeliverySlotExcelBtn from "./sections/DeliverySlotExcelBtn";

const EMPTY_DATA: DeliverySlotType[] = [];

function DeliverySlot() {
  const { data, refetch, isLoading, isFetching } = useDeliverySlotTable();

  const handleModalOpen = useDeliverySlotModalStore(
    (state) => state.handleModalOpen,
  );
  const handleModalClose = useDeliverySlotModalStore(
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
                Delivery Slots
              </h1>
              <p className="text-sm text-gray-500 mt-0.5">
                Delivery slots are managed here
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
              <DeliverySlotExcelBtn />
              <Button onClick={handleModalOpen}>
                <Plus size={16} /> Add
              </Button>
            </div>
          </div>
        </CardHeader>
        <div>
          <Separator orientation="horizontal" className="bg-gray-100" />
          <div className="px-4 py-3">
            <DeliverySlotFilters />
          </div>
        </div>
        {(data && data.meta.total > 0) || isLoading || isFetching ? (
          <div className="overflow-x-auto">
            <DeliverySlotTable
              deliverySlots={data?.data ?? EMPTY_DATA}
              loading={isLoading || isFetching}
            />
            <Separator orientation="horizontal" className="bg-gray-100" />
            {data && data.meta.total > 0 && (
              <CustomPagination totalCount={data ? data.meta.total : 1} />
            )}
          </div>
        ) : (
          <EmptyDataBlock
            title="No Delivery Slot Found"
            description="No delivery slots are available as of now. Please add now to get started."
          />
        )}
      </Card>
      <DeliverySlotForm />
    </div>
  );
}

export default DeliverySlot;
