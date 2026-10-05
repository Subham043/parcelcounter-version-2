// hooks/useBlogForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { blogFormSchema, type BlogFormValuesType } from "@/utils/data/schema/blog";
import { useBlogModalStore } from "../store/blog-modal.store";
import { useBlogCreateMutation, useBlogUpdateMutation } from "@/utils/data/mutation/blog";
import { useBlogQuery } from "@/utils/data/query/blog";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: BlogFormValuesType = {
    name: "",
    slug: "",
    heading: "",
    description: "",
    description_unfiltered: "",
    meta_title: undefined,
    meta_description: undefined,
    meta_keywords: [],
    is_active: true,
    is_popular: false,
    image: undefined
}

export function useBlogForm() {

    const modal = useBlogModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useBlogQuery(
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createBlogMutation = useBlogCreateMutation();
    const updateBlogMutation = useBlogUpdateMutation(modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(blogFormSchema) as Resolver<BlogFormValuesType>,
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
                is_popular: data?.is_popular || false,
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useBlogModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateBlogMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<BlogFormValuesType>);
                        },
                    });
                } else {
                    await createBlogMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<BlogFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createBlogMutation.mutateAsync, updateBlogMutation.mutateAsync, handleClose],
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
