// hooks/useUserForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { userFormSchema, type UserFormValuesType } from "@/utils/data/schema/user";
import { useUserModalStore } from "../store/user-modal.store";
import { useUserCreateMutation, useUserUpdateMutation } from "@/utils/data/mutation/user";
import { useUserQuery } from "@/utils/data/query/user";
import { handleFormServerErrors } from "@/utils/helper";

const FORM_DEFAULT_VALUES: UserFormValuesType = {
    name: "",
    phone: "",
    email: undefined,
    password: undefined,
    confirm_password: undefined,
    role: undefined,
    is_blocked: false,
    is_create: true,
}

export function useUserForm() {

    const modal = useUserModalStore(state => state.modal)

    const { data, isLoading, isFetching, isRefetching } = useUserQuery(
        modal.type === "update" ? modal.id : 0,
        modal.show && modal.type === "update",
        true
    );

    const createUserMutation = useUserCreateMutation();
    const updateUserMutation = useUserUpdateMutation(modal.type === 'update' ? modal.id : 0);

    const form = useForm({
        resolver: yupResolver(userFormSchema) as Resolver<UserFormValuesType>,
        defaultValues: FORM_DEFAULT_VALUES,
    });

    useEffect(() => {
        if (!modal.show) return;

        if (modal.type === "create") {
            form.reset(FORM_DEFAULT_VALUES);
            return;
        }

        if (modal.type === "update" && data) {
            const role = data?.roles?.length > 0 ? data.roles[0].name : undefined;
            form.reset({
                name: data?.name || "",
                phone: data?.phone || "",
                email: data?.email || undefined,
                is_blocked: data?.is_blocked || false,
                role: role || undefined,
                password: undefined,
                confirm_password: undefined,
                is_create: false
            });
        }
    }, [modal.show, modal.type, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
        useUserModalStore.getState().handleModalClose();
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (modal.type === "update") {
                    await updateUserMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<UserFormValuesType>);
                        },
                    });
                } else {
                    await createUserMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<UserFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [modal.type, form.handleSubmit, createUserMutation.mutateAsync, updateUserMutation.mutateAsync, handleClose],
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
