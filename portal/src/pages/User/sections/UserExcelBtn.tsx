import { useUserExportMutation } from "@/utils/data/mutation/user";
import { useCallback } from "react";
import ExcelExportButton from "@/components/ExcelExportButton";

function UserExcelBtn() {
  const userExportMutation = useUserExportMutation();

  const onExport = useCallback(async () => {
    await userExportMutation.mutateAsync(undefined);
  }, [userExportMutation.mutateAsync]);

  return (
    <ExcelExportButton
      loading={userExportMutation.isPending}
      onExport={onExport}
    />
  );
}

export default UserExcelBtn;
