// hooks/useBannerForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { bannerFormSchema, type BannerFormValuesType } from "@/utils/data/schema/banner";
import { useBannerModalStore } from "../store/banner-modal.store";
import { useBannerCreateMutation, useBannerUpdateMutation } from "@/utils/data/mutation/banner";
import { useBannerQuery } from "@/utils/data/query/banner";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: BannerFormValuesType = {
    title: undefined,
    alt: undefined,
    desktop_image: undefined,
    mobile_image: undefined,
    is_active: true,
    is_create: true,
}

export function useBannerForm() {

    const modal = useBannerModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useBannerQuery(
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createBannerMutation = useBannerCreateMutation();
    const updateBannerMutation = useBannerUpdateMutation(modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(bannerFormSchema) as Resolver<BannerFormValuesType>,
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
                alt: data?.alt || undefined,
                desktop_image: undefined,
                mobile_image: undefined,
                is_active: data?.is_active || true,
                is_create: false
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useBannerModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateBannerMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<BannerFormValuesType>);
                        },
                    });
                } else {
                    await createBannerMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<BannerFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createBannerMutation.mutateAsync, updateBannerMutation.mutateAsync, handleClose],
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
