// hooks/useDeliverySlotForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { deliverySlotFormSchema, type DeliverySlotFormValuesType } from "@/utils/data/schema/delivery_slot";
import { useDeliverySlotModalStore } from "../store/delivery-slot-modal.store";
import { useDeliverySlotCreateMutation, useDeliverySlotUpdateMutation } from "@/utils/data/mutation/delivery_slot";
import { useDeliverySlotQuery } from "@/utils/data/query/delivery_slot";
import { handleFormServerErrors } from "@/utils/helper";
import { format, parse } from "date-fns";

const FORM_DEFAULT_VALUES: DeliverySlotFormValuesType = {
    name: "",
    is_cod_allowed: false,
    start_time: "",
    end_time: "",
    is_active: true,
}

export function useDeliverySlotForm() {

    const modal = useDeliverySlotModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useDeliverySlotQuery(
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createDeliverySlotMutation = useDeliverySlotCreateMutation();
    const updateDeliverySlotMutation = useDeliverySlotUpdateMutation(modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(deliverySlotFormSchema) as Resolver<DeliverySlotFormValuesType>,
        defaultValues: FORM_DEFAULT_VALUES,
    });

    useEffect(() => {
        if (!modal.show) return;

        if (modal.type === "create") {
            form.reset(FORM_DEFAULT_VALUES);
            return;
        }

        if (modal.type === "update" && data) {
            form.reset({
                name: data?.name || "",
                start_time: data?.start_time ? format(parse(data.start_time, "HH:mm:ss", new Date()), "HH:mm") : "",
                end_time: data?.end_time ? format(parse(data.end_time, "HH:mm:ss", new Date()), "HH:mm") : "",
                is_cod_allowed: data?.is_cod_allowed || false,
                is_active: data?.is_active || true,
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useDeliverySlotModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateDeliverySlotMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<DeliverySlotFormValuesType>);
                        },
                    });
                } else {
                    await createDeliverySlotMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<DeliverySlotFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createDeliverySlotMutation.mutateAsync, updateDeliverySlotMutation.mutateAsync, handleClose],
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
