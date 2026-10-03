import { useToast } from "@/hooks/useToast";
import { useMutation } from "@tanstack/react-query";
import { useSearchParams } from "react-router";
import type { PaginationType, PaymentOptionType } from "@/utils/types";
import { togglePaymentOptionStatusHandler } from "../dal/payment_option";
import { PaymentOptionQueryKey, PaymentOptionsQueryKey } from "../query/payment_option";


export const usePaymentOptionToggleStatusMutation = (id: number) => {
    const { toastSuccess, toastError } = useToast();
    const [params] = useSearchParams();

    return useMutation({
        mutationFn: async () => {
            return await togglePaymentOptionStatusHandler(id);
        },
        onSuccess: (data, __, ___, context) => {
            toastSuccess("Payment option state toggled successfully");
            context.client.setQueryData(PaymentOptionsQueryKey(params), (oldData: PaginationType<PaymentOptionType> | undefined) => {
                if (!oldData) return oldData;
                const oldUserDataIndex = oldData.data.findIndex((user) => user.id === id);
                if (oldUserDataIndex !== -1) {
                    const newData = [...oldData.data];
                    newData[oldUserDataIndex] = data;
                    return {
                        ...oldData,
                        data: newData,
                    };
                }
                return oldData;
            });
            context.client.setQueryData(PaymentOptionQueryKey(id), data);
            context.client.setQueryData(PaymentOptionQueryKey(id, true), data);
        },
        onError: (error: any) => {
            toastError(error?.response?.data?.message || "Something went wrong, please try again later.");
        },
    });
};