import ReCAPTCHA from "react-google-recaptcha";
import { Controller, type Control } from "react-hook-form";
import { type LegacyRef, forwardRef } from "react";
import { env } from "@/configs/env";
import { Field, FieldError, FieldLabel } from "../ui/field";

type PropType = {
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  control: Control<any, any>;
  error: string | undefined;
};

const CaptchaInput = forwardRef(
  (props: PropType, ref: LegacyRef<ReCAPTCHA> | undefined) => {
    const { control, error } = props;
    return (
      <Controller
        name="captcha"
        control={control}
        render={({ field }) => (
          <Field>
            <FieldLabel htmlFor="captcha">Captcha</FieldLabel>
            <ReCAPTCHA
              ref={ref}
              sitekey={env.CAPTCHA_KEY}
              onChange={field.onChange}
              onExpired={() => field.onChange("")}
              onErrored={() => field.onChange("")}
            />
            {error && <FieldError errors={[{ message: error }]} />}
          </Field>
        )}
      />
    );
  },
);

export default CaptchaInput;
