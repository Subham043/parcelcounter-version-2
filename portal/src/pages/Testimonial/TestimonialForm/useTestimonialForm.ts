// hooks/useTestimonialForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { testimonialFormSchema, type TestimonialFormValuesType } from "@/utils/data/schema/testimonial";
import { useTestimonialModalStore } from "../store/testimonial-modal.store";
import { useTestimonialCreateMutation, useTestimonialUpdateMutation } from "@/utils/data/mutation/testimonial";
import { useTestimonialQuery } from "@/utils/data/query/testimonial";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: TestimonialFormValuesType = {
    name: "",
    designation: "",
    message: "",
    star: 5,
    is_active: true,
    image: undefined,
    is_create: true,
}

export function useTestimonialForm() {

    const modal = useTestimonialModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useTestimonialQuery(
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createTestimonialMutation = useTestimonialCreateMutation();
    const updateTestimonialMutation = useTestimonialUpdateMutation(modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(testimonialFormSchema) as Resolver<TestimonialFormValuesType>,
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
                designation: data?.designation || "",
                message: data?.message || "",
                star: data?.star || 5,
                is_active: data?.is_active || true,
                image: undefined,
                is_create: false
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useTestimonialModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateTestimonialMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<TestimonialFormValuesType>);
                        },
                    });
                } else {
                    await createTestimonialMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<TestimonialFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createTestimonialMutation.mutateAsync, updateTestimonialMutation.mutateAsync, handleClose],
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
