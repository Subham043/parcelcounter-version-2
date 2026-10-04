// hooks/useCategoryForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { categoryFormSchema, type CategoryFormValuesType } from "@/utils/data/schema/category";
import { useCategoryModalStore } from "../store/category-modal.store";
import { useCategoryCreateMutation, useCategoryUpdateMutation } from "@/utils/data/mutation/category";
import { useCategoryQuery } from "@/utils/data/query/category";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: CategoryFormValuesType = {
    name: "",
    slug: "",
    heading: "",
    description: "",
    description_unfiltered: "",
    meta_title: undefined,
    meta_description: undefined,
    meta_keywords: [],
    is_active: true,
    image: undefined
}

export function useCategoryForm() {

    const modal = useCategoryModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useCategoryQuery(
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createCategoryMutation = useCategoryCreateMutation();
    const updateCategoryMutation = useCategoryUpdateMutation(modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(categoryFormSchema) as Resolver<CategoryFormValuesType>,
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
        useCategoryModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateCategoryMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<CategoryFormValuesType>);
                        },
                    });
                } else {
                    await createCategoryMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<CategoryFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createCategoryMutation.mutateAsync, updateCategoryMutation.mutateAsync, handleClose],
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
