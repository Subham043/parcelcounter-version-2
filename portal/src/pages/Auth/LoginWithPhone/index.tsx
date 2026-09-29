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
  FieldGroup,
  FieldLabel,
  FieldSeparator,
} from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import { page_routes } from "@/utils/routes/page_routes";
import { Mail, Phone } from "lucide-react";
import { Link } from "react-router";

function LoginWithPhone() {
  return (
    <Card>
      <CardHeader className="text-center">
        <CardTitle className="text-xl">Welcome back</CardTitle>
        <CardDescription>Login with your phone and otp</CardDescription>
      </CardHeader>
      <CardContent>
        <form>
          <FieldGroup>
            <Field>
              <FieldLabel htmlFor="phone">Phone</FieldLabel>
              <Input id="phone" type="text" placeholder="1234567890" required />
            </Field>
            <Field>
              <FieldLabel htmlFor="otp">OTP</FieldLabel>
              <Input id="otp" type="text" placeholder="1234567890" required />
            </Field>
            <Field>
              <Button type="submit">Login</Button>
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
                render={<Link to={page_routes.login_with_email.link} />}
              >
                <Mail data-icon="inline-start" />
                Login with Email & Password
              </Button>
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
            </Field>
          </FieldGroup>
        </form>
      </CardContent>
    </Card>
  );
}

export default LoginWithPhone;
