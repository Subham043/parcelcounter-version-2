import { usePasswordUpdateForm } from "./usePasswordUpdateForm";
import { Controller } from "react-hook-form";
import { Card, CardHeader } from "@/components/ui/card";
import { Save } from "lucide-react";
import { Separator } from "@/components/ui/separator";
import {
  Field,
  FieldError,
  FieldGroup,
  FieldLabel,
} from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import { Spinner } from "@/components/ui/spinner";
import { Button } from "@/components/ui/button";

/*
 * My Password Page
 */
export default function Password() {
  const { form, onSubmit } = usePasswordUpdateForm();

  return (
    <form onSubmit={onSubmit}>
      <Card className="rounded-sm py-0 gap-0">
        <CardHeader className="px-4 py-3">
          <div className="flex items-end justify-between gap-4">
            <div>
              <h1 className="text-2xl font-bold text-gray-900">Password</h1>
              <p className="text-sm text-gray-500 mt-0.5">
                Update your password here
              </p>
            </div>
            <div className="flex items-center gap-2">
              <Button type="submit" disabled={form.formState.isSubmitting}>
                {form.formState.isSubmitting ? (
                  <Spinner className="size-5" data-icon="inline-start" />
                ) : (
                  <Save size={16} />
                )}
                {form.formState.isSubmitting ? "Saving..." : "Save"}
              </Button>
            </div>
          </div>
        </CardHeader>
        <Separator orientation="horizontal" className="bg-gray-100" />
        <div className="p-4">
          <FieldGroup className="grid grid-cols-1 gap-4 md:grid-cols-3">
            <Controller
              control={form.control}
              name="old_password"
              render={({ field, fieldState }) => (
                <Field>
                  <FieldLabel htmlFor="old_password">
                    Current Password
                  </FieldLabel>
                  <Input
                    id="old_password"
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
          </FieldGroup>
        </div>
      </Card>
    </form>
  );
}
