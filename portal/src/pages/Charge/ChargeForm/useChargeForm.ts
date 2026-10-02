// hooks/useChargeForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { chargeFormSchema, type ChargeFormValuesType } from "@/utils/data/schema/charge";
import { useChargeModalStore } from "../store/charge-modal.store";
import { useChargeCreateMutation, useChargeUpdateMutation } from "@/utils/data/mutation/charge";
import { useChargeQuery } from "@/utils/data/query/charge";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: ChargeFormValuesType = {
    name: "",
    slug: "",
    is_percentage: false,
    value: 0,
    include_charges_for_cart_price_below: undefined,
    is_active: true,
}

export function useChargeForm() {

    const modal = useChargeModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useChargeQuery(
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createChargeMutation = useChargeCreateMutation();
    const updateChargeMutation = useChargeUpdateMutation(modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(chargeFormSchema) as Resolver<ChargeFormValuesType>,
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
                slug: data?.slug || "",
                is_percentage: data?.is_percentage || false,
                value: data?.value || 0,
                include_charges_for_cart_price_below: data?.include_charges_for_cart_price_below || undefined,
                is_active: data?.is_active || true,
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useChargeModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateChargeMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ChargeFormValuesType>);
                        },
                    });
                } else {
                    await createChargeMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ChargeFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createChargeMutation.mutateAsync, updateChargeMutation.mutateAsync, handleClose],
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
