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
} from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import { page_routes } from "@/utils/routes/page_routes";
import { Link } from "react-router";
import { useRegister } from "./useRegister";
import { Spinner } from "@/components/ui/spinner";
import { Controller } from "react-hook-form";
import CaptchaInput from "@/components/CaptchaInput";

function Register() {
  const { form, onSubmit, captchaRef } = useRegister();
  return (
    <Card>
      <CardHeader className="text-center">
        <CardTitle className="text-xl">Register Account</CardTitle>
        <CardDescription>Create your account to get started.</CardDescription>
      </CardHeader>
      <CardContent>
        <form onSubmit={onSubmit}>
          <FieldGroup>
            <Controller
              control={form.control}
              name="name"
              render={({ field, fieldState }) => (
                <Field>
                  <FieldLabel htmlFor="name">Name</FieldLabel>
                  <Input
                    id="name"
                    type="text"
                    placeholder="John Doe"
                    value={field.value}
                    onChange={field.onChange}
                  />
                  {fieldState.invalid && (
                    <FieldError errors={[fieldState.error]} />
                  )}
                </Field>
              )}
            />
            <Controller
              control={form.control}
              name="email"
              render={({ field, fieldState }) => (
                <Field>
                  <FieldLabel htmlFor="email">Email (Optional)</FieldLabel>
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
              name="phone"
              render={({ field, fieldState }) => (
                <Field>
                  <FieldLabel htmlFor="phone">Phone</FieldLabel>
                  <Input
                    id="phone"
                    type="number"
                    placeholder="1234567890"
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
                  <FieldLabel htmlFor="password">Password</FieldLabel>
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
            <Controller
              control={form.control}
              name="confirm_password"
              render={({ field, fieldState }) => (
                <Field>
                  <FieldLabel htmlFor="confirm_password">
                    Confirm Password
                  </FieldLabel>
                  <Input
                    id="confirm_password"
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
            <Controller
              control={form.control}
              name="referral_code"
              render={({ field, fieldState }) => (
                <Field>
                  <FieldLabel htmlFor="referral_code">
                    Referral Code (Optional)
                  </FieldLabel>
                  <Input
                    id="referral_code"
                    type="text"
                    placeholder="ABC123"
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
                {form.formState.isSubmitting ? "Registering..." : "Register"}
              </Button>
              <FieldDescription className="text-center">
                Already have an account?{" "}
                <Link
                  to={page_routes.login_with_phone.link}
                  className="font-medium underline-offset-4 hover:underline"
                >
                  Login here
                </Link>
              </FieldDescription>
            </Field>
          </FieldGroup>
        </form>
      </CardContent>
    </Card>
  );
}

export default Register;
