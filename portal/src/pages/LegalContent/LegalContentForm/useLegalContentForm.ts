// hooks/useLegalContentForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { legalContentFormSchema, type LegalContentFormValuesType } from "@/utils/data/schema/legal_content";
import { useLegalContentModalStore } from "../store/legal-content-modal.store";
import { useLegalContentCreateMutation, useLegalContentUpdateMutation } from "@/utils/data/mutation/legal_content";
import { useLegalContentQuery } from "@/utils/data/query/legal_content";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: LegalContentFormValuesType = {
    name: "",
    slug: "",
    heading: "",
    description: "",
    description_unfiltered: "",
    meta_title: undefined,
    meta_description: undefined,
    meta_keywords: [],
    is_active: true,
}

export function useLegalContentForm() {

    const modal = useLegalContentModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useLegalContentQuery(
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createLegalContentMutation = useLegalContentCreateMutation();
    const updateLegalContentMutation = useLegalContentUpdateMutation(modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(legalContentFormSchema) as Resolver<LegalContentFormValuesType>,
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
                heading: data?.heading || "",
                description: data?.description || "",
                description_unfiltered: data?.description_unfiltered || "",
                meta_title: data?.meta_title || undefined,
                meta_description: data?.meta_description || undefined,
                meta_keywords: data?.meta_keywords.split(",") || [] as unknown as string[],
                is_active: data?.is_active || true,
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useLegalContentModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateLegalContentMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<LegalContentFormValuesType>);
                        },
                    });
                } else {
                    await createLegalContentMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<LegalContentFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createLegalContentMutation.mutateAsync, updateLegalContentMutation.mutateAsync, handleClose],
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
