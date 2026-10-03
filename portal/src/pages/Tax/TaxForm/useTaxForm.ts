// hooks/useTaxForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { taxFormSchema, type TaxFormValuesType } from "@/utils/data/schema/tax";
import { useTaxModalStore } from "../store/tax-modal.store";
import { useTaxCreateMutation, useTaxUpdateMutation } from "@/utils/data/mutation/tax";
import { useTaxQuery } from "@/utils/data/query/tax";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: TaxFormValuesType = {
    name: "",
    slug: "",
    value: 0,
    is_inter_state_tax: false,
    is_active: true,
}

export function useTaxForm() {

    const modal = useTaxModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useTaxQuery(
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createTaxMutation = useTaxCreateMutation();
    const updateTaxMutation = useTaxUpdateMutation(modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(taxFormSchema) as Resolver<TaxFormValuesType>,
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
                value: data?.value || 0,
                is_inter_state_tax: data?.is_inter_state_tax || false,
                is_active: data?.is_active || true,
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useTaxModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateTaxMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<TaxFormValuesType>);
                        },
                    });
                } else {
                    await createTaxMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<TaxFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createTaxMutation.mutateAsync, updateTaxMutation.mutateAsync, handleClose],
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
