// hooks/useAboutSectionForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { aboutSectionFormSchema, type AboutSectionFormValuesType } from "@/utils/data/schema/about_section";
import { useAboutSectionModalStore } from "../store/about-section-modal.store";
import { useAboutSectionCreateMutation, useAboutSectionUpdateMutation } from "@/utils/data/mutation/about_section";
import { useAboutSectionQuery } from "@/utils/data/query/about_section";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: AboutSectionFormValuesType = {
    is_create: true,
    heading: "",
    description: "",
    description_unfiltered: "",
    is_active: true,
    image: undefined
}

export function useAboutSectionForm() {

    const modal = useAboutSectionModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useAboutSectionQuery(
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createAboutSectionMutation = useAboutSectionCreateMutation();
    const updateAboutSectionMutation = useAboutSectionUpdateMutation(modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(aboutSectionFormSchema) as Resolver<AboutSectionFormValuesType>,
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
                heading: data?.heading || "",
                description: data?.description || "",
                description_unfiltered: data?.description_unfiltered || "",
                is_active: data?.is_active || true,
                is_create: false
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useAboutSectionModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateAboutSectionMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<AboutSectionFormValuesType>);
                        },
                    });
                } else {
                    await createAboutSectionMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<AboutSectionFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createAboutSectionMutation.mutateAsync, updateAboutSectionMutation.mutateAsync, handleClose],
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
