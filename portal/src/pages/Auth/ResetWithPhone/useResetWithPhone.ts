import { yupResolver } from "@hookform/resolvers/yup";
import { useCallback, useRef } from "react";
import { useForm } from "react-hook-form";
import ReCAPTCHA from "react-google-recaptcha";
import { handleFormServerErrors } from "@/utils/helper";
import { usePhoneForgotPasswordMutation } from "@/utils/data/mutation/auth";
import { phoneForgotPasswordSchema, type PhoneForgotPasswordFormValuesType } from "@/utils/data/schema/auth";

export function useResetWithPhone() {
  const captchaRef = useRef<ReCAPTCHA>(null);
  const forgotPasswordMutation = usePhoneForgotPasswordMutation()

  const form = useForm<PhoneForgotPasswordFormValuesType>({
    resolver: yupResolver(phoneForgotPasswordSchema),
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
              phone: "",
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
