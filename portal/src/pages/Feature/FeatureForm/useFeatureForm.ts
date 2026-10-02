// hooks/useFeatureForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { featureFormSchema, type FeatureFormValuesType } from "@/utils/data/schema/feature";
import { useFeatureModalStore } from "../store/feature-modal.store";
import { useFeatureCreateMutation, useFeatureUpdateMutation } from "@/utils/data/mutation/feature";
import { useFeatureQuery } from "@/utils/data/query/feature";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: FeatureFormValuesType = {
    title: "",
    description: "",
    is_active: true,
    image: undefined,
    is_create: true,
}

export function useFeatureForm() {

    const modal = useFeatureModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useFeatureQuery(
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createFeatureMutation = useFeatureCreateMutation();
    const updateFeatureMutation = useFeatureUpdateMutation(modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(featureFormSchema) as Resolver<FeatureFormValuesType>,
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
                title: data?.title || "",
                description: data?.description || "",
                is_active: data?.is_active || true,
                image: undefined,
                is_create: false
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useFeatureModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateFeatureMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<FeatureFormValuesType>);
                        },
                    });
                } else {
                    await createFeatureMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<FeatureFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createFeatureMutation.mutateAsync, updateFeatureMutation.mutateAsync, handleClose],
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
