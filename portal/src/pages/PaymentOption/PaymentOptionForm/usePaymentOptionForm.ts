// hooks/usePaymentOptionForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { paymentOptionFormSchema, type PaymentOptionFormValuesType } from "@/utils/data/schema/payment_option";
import { usePaymentOptionModalStore } from "../store/payment-option-modal.store";
import { usePaymentOptionUpdateMutation } from "@/utils/data/mutation/payment_option";
import { usePaymentOptionQuery } from "@/utils/data/query/payment_option";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: PaymentOptionFormValuesType = {
    description: "",
    is_active: true,
    image: undefined,
    is_create: false,
}

export function usePaymentOptionForm() {

    const modal = usePaymentOptionModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = usePaymentOptionQuery(
        modal.show ? modal.id : 0,
        modal.show,
        true
    );

    const updatePaymentOptionMutation = usePaymentOptionUpdateMutation(modal.show ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(paymentOptionFormSchema) as Resolver<PaymentOptionFormValuesType>,
        defaultValues: FORM_DEFAULT_VALUES,
    });

    useEffect(() => {
        if (!modal.show) return;

        if (data) {
            form.reset({
                description: data?.description || "",
                is_active: data?.is_active,
                image: undefined,
                is_create: false
            });
        }
    }, [modal.show, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        usePaymentOptionModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                await updatePaymentOptionMutation.mutateAsync(values, {
                    onSuccess: () => {
                        handleClose();
                    },
                    onError: (error) => {
                        handleFormServerErrors(error, form as UseFormReturn<PaymentOptionFormValuesType>);
                    },
                });
            })(event);
        },
        [form.handleSubmit, updatePaymentOptionMutation.mutateAsync, handleClose],
    );

    return {
        form,
        modal,
        data,
        isLoading: isLoading || isFetching || isRefetching,
        onSubmit,
        handleClose,
    };
}
