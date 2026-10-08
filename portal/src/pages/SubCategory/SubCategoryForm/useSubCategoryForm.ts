// hooks/useSubCategoryForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { subCategoryFormSchema, type SubCategoryFormValuesType } from "@/utils/data/schema/sub_category";
import { useSubCategoryModalStore } from "../store/sub-category-modal.store";
import { useSubCategoryCreateMutation, useSubCategoryUpdateMutation } from "@/utils/data/mutation/sub_category";
import { useSubCategoryQuery } from "@/utils/data/query/sub_category";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: SubCategoryFormValuesType = {
    is_create: true,
    name: "",
    slug: "",
    heading: "",
    description: "",
    description_unfiltered: "",
    meta_title: undefined,
    meta_description: undefined,
    meta_keywords: [],
    is_active: true,
    image: undefined,
    category: []
}

export function useSubCategoryForm() {

    const modal = useSubCategoryModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useSubCategoryQuery(
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        { includeCategory: true },
        true,
    );

    const createSubCategoryMutation = useSubCategoryCreateMutation();
    const updateSubCategoryMutation = useSubCategoryUpdateMutation(modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(subCategoryFormSchema) as Resolver<SubCategoryFormValuesType>,
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
                meta_keywords: data?.meta_keywords?.split(",") || [] as unknown as string[],
                is_active: data?.is_active || true,
                category: data?.categories?.map((category) => ({
                    label: category.name,
                    value: category.id,
                })) || [],
                is_create: false
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useSubCategoryModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateSubCategoryMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<SubCategoryFormValuesType>);
                        },
                    });
                } else {
                    await createSubCategoryMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<SubCategoryFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createSubCategoryMutation.mutateAsync, updateSubCategoryMutation.mutateAsync, handleClose],
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
