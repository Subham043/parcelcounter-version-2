import { toast } from "@/components/ui/toast";
import { useCallback } from "react";

/*
 * Toast Hook Type
 */
type ToastHookType = () => {
  toastDismiss: () => void;
  toastSuccess: (msg: string) => void;
  toastError: (msg: string) => void;
  toastInfo: (msg: string) => void;
};

export const toastDismissFunc = () => {
  toast.close();
};
export const toastSuccessFunc = (msg: string) => {
  toastDismissFunc();
  toast.add({
    type: "success",
    description: msg,
  });
};
export const toastErrorFunc = (msg: string) => {
  toastDismissFunc();
  toast.add({
    type: "error",
    description: msg,
    priority: "high",
  });
};
export const toastInfoFunc = (msg: string) => {
  toastDismissFunc();
  toast.add({
    type: "info",
    description: msg,
  });
};

/*
 * Toast Configuration
 */

/*
  Toast Hook Function: This hook is used to have common toast configs at one place
*/
export const useToast: ToastHookType = () => {
  const toastDismiss = useCallback(toastDismissFunc, []);
  const toastSuccess = useCallback(toastSuccessFunc, []);
  const toastError = useCallback(toastErrorFunc, []);
  const toastInfo = useCallback(toastInfoFunc, []);

  return {
    toastDismiss,
    toastSuccess,
    toastError,
    toastInfo,
  };
};
