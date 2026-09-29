import { Button } from "@/components/ui/button";
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import {
  Field,
  FieldDescription,
  FieldError,
  FieldGroup,
  FieldLabel,
  FieldSeparator,
} from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import { page_routes } from "@/utils/routes/page_routes";
import { Phone } from "lucide-react";
import { Link } from "react-router";
import { useResetWithEmail } from "./useResetWithEmail";
import { Controller } from "react-hook-form";
import CaptchaInput from "@/components/CaptchaInput";
import { Spinner } from "@/components/ui/spinner";

function ResetWithEmail() {
  const { form, onSubmit, captchaRef } = useResetWithEmail();
  return (
    <Card>
      <CardHeader className="text-center">
        <CardTitle className="text-xl">Forgot Password</CardTitle>
        <CardDescription>
          Enter your email to reset your password
        </CardDescription>
      </CardHeader>
      <CardContent>
        <form onSubmit={onSubmit}>
          <FieldGroup>
            <Controller
              control={form.control}
              name="email"
              render={({ field, fieldState }) => (
                <Field>
                  <FieldLabel htmlFor="email">Email</FieldLabel>
                  <Input
                    id="email"
                    type="email"
                    placeholder="m@example.com"
                    value={field.value}
                    onChange={field.onChange}
                    required
                  />
                  {fieldState.invalid && (
                    <FieldError errors={[fieldState.error]} />
                  )}
                </Field>
              )}
            />
            <CaptchaInput
              control={form.control}
              error={form.formState.errors.captcha?.message}
              ref={captchaRef}
            />
            <Field>
              <Button type="submit" disabled={form.formState.isSubmitting}>
                {form.formState.isSubmitting && (
                  <Spinner className="size-5" data-icon="inline-start" />
                )}
                {form.formState.isSubmitting ? "Resetting..." : "Reset"}
              </Button>
              <FieldDescription className="text-center">
                Already have an account?{" "}
                <Link to={page_routes.login_with_email.link}>Sign in</Link>
              </FieldDescription>
            </Field>
            <FieldSeparator className="*:data-[slot=field-separator-content]:bg-card">
              Or reset with
            </FieldSeparator>
            <Field>
              <Button
                variant="outline"
                type="button"
                render={<Link to={page_routes.reset_with_phone.link} />}
              >
                <Phone data-icon="inline-start" />
                Reset with Phone
              </Button>
            </Field>
          </FieldGroup>
        </form>
      </CardContent>
    </Card>
  );
}

export default ResetWithEmail;
