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
import { Phone, SquareAsterisk } from "lucide-react";
import { Link } from "react-router";
import { useLoginWithEmail } from "./useLoginWithEmail";
import { Controller } from "react-hook-form";
import CaptchaInput from "@/components/CaptchaInput";
import { Spinner } from "@/components/ui/spinner";

function LoginWithEmail() {
  const { form, onSubmit, captchaRef } = useLoginWithEmail();
  return (
    <Card>
      <CardHeader className="text-center">
        <CardTitle className="text-xl">Welcome back</CardTitle>
        <CardDescription>Login with your email and password</CardDescription>
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
            <Controller
              control={form.control}
              name="password"
              render={({ field, fieldState }) => (
                <Field>
                  <div className="flex items-center">
                    <FieldLabel htmlFor="password">Password</FieldLabel>
                    <Link
                      to={page_routes.reset_with_email.link}
                      className="ml-auto text-sm underline-offset-4 hover:underline"
                    >
                      Forgot your password?
                    </Link>
                  </div>
                  <Input
                    id="password"
                    type="password"
                    required
                    value={field.value}
                    onChange={field.onChange}
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
                {form.formState.isSubmitting ? "Login..." : "Login"}
              </Button>
              <FieldDescription className="text-center">
                Don&apos;t have an account?{" "}
                <Link to={page_routes.sign_up.link}>Sign up</Link>
              </FieldDescription>
            </Field>
            <FieldSeparator className="*:data-[slot=field-separator-content]:bg-card">
              Or continue with
            </FieldSeparator>
            <Field>
              <Button
                variant="outline"
                type="button"
                render={
                  <Link to={page_routes.login_with_phone_password.link} />
                }
              >
                <Phone data-icon="inline-start" />
                Login with Phone & Password
              </Button>
              <Button
                variant="outline"
                type="button"
                render={<Link to={page_routes.login_with_phone.link} />}
              >
                <SquareAsterisk data-icon="inline-start" />
                Login with Phone & OTP
              </Button>
            </Field>
          </FieldGroup>
        </form>
      </CardContent>
    </Card>
  );
}

export default LoginWithEmail;
