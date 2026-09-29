import { yupResolver } from "@hookform/resolvers/yup";
import { useCallback, useRef } from "react";
import { useForm } from "react-hook-form";
import ReCAPTCHA from "react-google-recaptcha";
import { handleFormServerErrors } from "@/utils/helper";
import { useEmailForgotPasswordMutation } from "@/utils/data/mutation/auth";
import { emailForgotPasswordSchema, type EmailForgotPasswordFormValuesType } from "@/utils/data/schema/auth";

export function useResetWithEmail() {
  const captchaRef = useRef<ReCAPTCHA>(null);
  const forgotPasswordMutation = useEmailForgotPasswordMutation()

  const form = useForm<EmailForgotPasswordFormValuesType>({
    resolver: yupResolver(emailForgotPasswordSchema),
  });

  const onSubmit = useCallback(
    (event: React.FormEvent<HTMLFormElement>) => {
      form.handleSubmit(async (values) => {
        await forgotPasswordMutation.mutateAsync(values, {
          onError: (error) => {
            form.resetField("captcha")
            handleFormServerErrors(error, form);
          },
          onSuccess: () => {
            form.reset({
              email: "",
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
    [form, forgotPasswordMutation],
  );

  return {
    form,
    captchaRef,
    onSubmit,
  };
}
