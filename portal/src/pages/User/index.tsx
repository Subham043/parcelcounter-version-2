import { Button } from "@/components/ui/button";
import { Card, CardHeader } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { Plus, RefreshCw } from "lucide-react";
import type { UserType } from "@/utils/types";
import { useUserTable } from "./sections/useUserTable";
import { useUserModalStore } from "./store/user-modal.store";
import { useEffect } from "react";
import UserFilters from "./sections/UserFilters";
import UserTable from "./sections/UserTable";
import EmptyDataBlock from "@/components/EmptyDataBlock";
import CustomPagination from "@/components/CustomPagination";
import UserForm from "./UserForm";
import UserExcelBtn from "./sections/UserExcelBtn";

const EMPTY_DATA: UserType[] = [];

function User() {
  const { data, refetch, isLoading, isFetching } = useUserTable();

  const handleModalOpen = useUserModalStore((state) => state.handleModalOpen);
  const handleModalClose = useUserModalStore((state) => state.handleModalClose);

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
              <h1 className="text-2xl font-bold text-gray-900">Users</h1>
              <p className="text-sm text-gray-500 mt-0.5">
                Users are managed here
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
              <UserExcelBtn />
              <Button onClick={handleModalOpen}>
                <Plus size={16} /> Add
              </Button>
            </div>
          </div>
        </CardHeader>
        <div>
          <Separator orientation="horizontal" className="bg-gray-100" />
          <div className="px-4 py-3">
            <UserFilters />
          </div>
        </div>
        {(data && data.meta.total > 0) || isLoading || isFetching ? (
          <div className="overflow-x-auto">
            <UserTable
              users={data?.data ?? EMPTY_DATA}
              loading={isLoading || isFetching}
            />
            <Separator orientation="horizontal" className="bg-gray-100" />
            {data && data.meta.total > 0 && (
              <CustomPagination totalCount={data ? data.meta.total : 1} />
            )}
          </div>
        ) : (
          <EmptyDataBlock
            title="No User Found"
            description="No users are available as of now. Please add now to get started."
          />
        )}
      </Card>
      <UserForm />
    </div>
  );
}

export default User;
