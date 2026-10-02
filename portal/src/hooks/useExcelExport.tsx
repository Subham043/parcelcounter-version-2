import { useCallback, useState } from "react";
import axios from "@/utils/axios";
import { useToast } from "./useToast";
import type { GenericAbortSignal } from "axios";
import { PAGEKEY, TOTALKEY } from "./usePaginationQueryParam";
import { useSearchParams } from "react-router";

/*
 * Toast Hook Type
 */
type ExcelExportHookType = () => {
  excelLoading: boolean;
  exportExcel: (excel_url: string, excel_file_name: string) => Promise<void>;
};

/*
  Toast Hook Function: This hook is used to have common toast configs at one place
*/
export const useExcelExport: ExcelExportHookType = () => {
  const { toastError, toastSuccess } = useToast();
  const [excelLoading, setExcelLoading] = useState<boolean>(false);
  const [params] = useSearchParams();

  const exportExcel = useCallback(
    async (
      excel_url: string,
      excel_file_name: string,
      signal?: GenericAbortSignal | undefined,
    ) => {
      setExcelLoading(true);
      try {
        if (params.has(PAGEKEY)) {
          params.delete(PAGEKEY);
        }
        if (params.has(TOTALKEY)) {
          params.delete(TOTALKEY);
        }
        const response = await axios.get(excel_url, {
          params,
          signal,
          responseType: "blob",
        });
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", excel_file_name);
        document.body.appendChild(link);
        link.click();
        link.remove();
        window.URL.revokeObjectURL(url);
        toastSuccess("Excel Exported Successfully");
      } catch (error) {
        toastError("Something went wrong. Please try again later.");
      } finally {
        setExcelLoading(false);
      }
    },
    [toastError, toastSuccess, params.toString()],
  );

  return {
    exportExcel,
    excelLoading,
  };
};
