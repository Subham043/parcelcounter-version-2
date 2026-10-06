import { yupResolver } from "@hookform/resolvers/yup";
import { useForm, type UseFormReturn } from "react-hook-form";
import { useCallback } from "react";
import { usePasswordUpdateMutation } from "@/utils/data/mutation/profile";
import { handleFormServerErrors } from "@/utils/helper";
import { passwordUpdateFormSchema, type PasswordUpdateFormValuesType } from "@/utils/data/schema/profile";

const FORM_DEFAULT_VALUES: PasswordUpdateFormValuesType = {
  old_password: "",
  password: "",
  confirm_password: "",
}

export function usePasswordUpdateForm() {
  const passwordUpdate = usePasswordUpdateMutation();

  const form = useForm<PasswordUpdateFormValuesType>({
    resolver: yupResolver(passwordUpdateFormSchema),
    defaultValues: FORM_DEFAULT_VALUES
  });

  const handleClose = useCallback(() => {
    form.reset(FORM_DEFAULT_VALUES);
  }, [form.reset]);

  const onSubmit = useCallback(
    (event: React.FormEvent<HTMLFormElement>) => {
      form.handleSubmit(async (values) => {
        await passwordUpdate.mutateAsync({ ...values, }, {
          onSuccess: () => {
            handleClose();
          },
          onError: (error) => {
            handleFormServerErrors(error, form as UseFormReturn<PasswordUpdateFormValuesType>);
          },
        });
      })(event);
    },
    [form.handleSubmit, passwordUpdate.mutateAsync, handleClose],
  );

  return {
    form,
    onSubmit,
  };
}
