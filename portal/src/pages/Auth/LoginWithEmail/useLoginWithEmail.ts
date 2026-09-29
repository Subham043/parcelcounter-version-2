import { yupResolver } from "@hookform/resolvers/yup";
import { useCallback, useRef } from "react";
import { useForm } from "react-hook-form";
import ReCAPTCHA from "react-google-recaptcha";
import { handleFormServerErrors } from "@/utils/helper";
import { useEmailLoginMutation } from "@/utils/data/mutation/auth";
import { emailoginSchema, type EmailLoginFormValuesType } from "@/utils/data/schema/auth";

export function useLoginWithEmail() {
  const captchaRef = useRef<ReCAPTCHA>(null);
  const login = useEmailLoginMutation()

  const form = useForm<EmailLoginFormValuesType>({
    resolver: yupResolver(emailoginSchema),
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
              email: "",
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
