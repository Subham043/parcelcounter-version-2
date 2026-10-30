// hooks/useCertificationForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { certificationFormSchema, type CertificationFormValuesType } from "@/utils/data/schema/certification";
import { useCertificationModalStore } from "../store/certification-modal.store";
import { useCertificationCreateMutation, useCertificationUpdateMutation } from "@/utils/data/mutation/certification";
import { useCertificationQuery } from "@/utils/data/query/certification";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: CertificationFormValuesType = {
    title: undefined,
    image: undefined,
    is_active: true,
    is_create: true,
}

export function useCertificationForm() {

    const modal = useCertificationModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useCertificationQuery(
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createCertificationMutation = useCertificationCreateMutation();
    const updateCertificationMutation = useCertificationUpdateMutation(modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(certificationFormSchema) as Resolver<CertificationFormValuesType>,
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
                title: data?.title || undefined,
                image: undefined,
                is_active: data?.is_active,
                is_create: false
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useCertificationModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateCertificationMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<CertificationFormValuesType>);
                        },
                    });
                } else {
                    await createCertificationMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<CertificationFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createCertificationMutation.mutateAsync, updateCertificationMutation.mutateAsync, handleClose],
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
