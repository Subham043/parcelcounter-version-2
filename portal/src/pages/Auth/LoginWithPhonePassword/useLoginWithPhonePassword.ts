import { yupResolver } from "@hookform/resolvers/yup";
import { useCallback, useRef } from "react";
import { useForm } from "react-hook-form";
import ReCAPTCHA from "react-google-recaptcha";
import { handleFormServerErrors } from "@/utils/helper";
import { usePhonePasswordLoginMutation } from "@/utils/data/mutation/auth";
import { phonePasswordLoginFormSchema, type PhonePasswordLoginFormValuesType } from "@/utils/data/schema/auth";

export function useLoginWithPhonePassword() {
  const captchaRef = useRef<ReCAPTCHA>(null);
  const login = usePhonePasswordLoginMutation()

  const form = useForm<PhonePasswordLoginFormValuesType>({
    resolver: yupResolver(phonePasswordLoginFormSchema),
  });

  const onSubmit = useCallback(
    (event: React.FormEvent<HTMLFormElement>) => {
      form.handleSubmit(async (values) => {
        await login.mutateAsync(values, {
          onError: (error) => {
            form.resetField("captcha")
            handleFormServerErrors(error, form);
          },
          onSuccess: () => {
            form.reset({
              phone: "",
              password: "",
              captcha: "",
            });
            // navigate(from, { replace: true });
          },
          onSettled: () => {
            captchaRef.current?.reset();
          },
        });
      })(event);
    },
    [form, login],
  );

  return {
    form,
    captchaRef,
    onSubmit,
  };
}
