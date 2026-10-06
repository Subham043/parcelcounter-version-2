import { yupResolver } from "@hookform/resolvers/yup";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { handleFormServerErrors } from "@/utils/helper";
import { useProfileQuery } from "@/utils/data/query/profile";
import { useProfileUpdateMutation } from "@/utils/data/mutation/profile";
import { useCallback, useEffect } from "react";
import { profileUpdateFormSchema, type ProfileUpdateFormValuesType } from "@/utils/data/schema/profile";

const FORM_DEFAULT_VALUES: ProfileUpdateFormValuesType = {
  name: "",
  email: undefined,
  phone: "",
}

export function useProfileUpdateForm() {
  const { data, isLoading: isProfileLoading, isFetching: isProfileFetching, isRefetching: isProfileRefetching, refetch } = useProfileQuery()
  const profileUpdate = useProfileUpdateMutation();

  const form = useForm<ProfileUpdateFormValuesType>({
    resolver: yupResolver(profileUpdateFormSchema) as Resolver<ProfileUpdateFormValuesType>,
    defaultValues: FORM_DEFAULT_VALUES
  });

  useEffect(() => {
    if (data) {
      form.reset({
        name: data.name || "",
        email: data.email ? data.email : undefined,
        phone: data.phone || "",
      });
    }
  }, [data, form.reset]);

  const onSubmit = useCallback(
    (event: React.FormEvent<HTMLFormElement>) => {
      form.handleSubmit(async (values) => {
        await profileUpdate.mutateAsync({ ...values, }, {
          onError: (error) => {
            handleFormServerErrors(error, form as UseFormReturn<ProfileUpdateFormValuesType>);
          },
        });
      })(event);
    },
    [form.handleSubmit, profileUpdate.mutateAsync],
  );

  return {
    form,
    isProfileLoading,
    isProfileFetching,
    isProfileRefetching,
    data,
    onSubmit,
    refetch
  };
}
