import { yupResolver } from "@hookform/resolvers/yup";
import { useCallback, useRef } from "react";
import { useForm } from "react-hook-form";
import ReCAPTCHA from "react-google-recaptcha";
import { handleFormServerErrors } from "@/utils/helper";
import { useRegisterMutation } from "@/utils/data/mutation/auth";
import { registerSchema, type RegisterFormValuesType } from "@/utils/data/schema/auth";

export function useRegister() {
  const captchaRef = useRef<ReCAPTCHA>(null);
  const register = useRegisterMutation()

  const form = useForm<RegisterFormValuesType>({
    resolver: yupResolver(registerSchema),
  });

  const onSubmit = useCallback(
    (event: React.FormEvent<HTMLFormElement>) => {
      form.handleSubmit(async (values) => {
        await register.mutateAsync(values, {
          onError: (error) => {
            form.resetField("captcha")
            handleFormServerErrors(error, form);
          },
          onSuccess: () => {
            form.reset({
              email: "",
              phone: "",
              password: "",
              confirm_password: "",
              role: "App Promoter",
              referral_code: "",
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
    [form, register],
  );

  return {
    form,
    captchaRef,
    onSubmit,
  };
}
