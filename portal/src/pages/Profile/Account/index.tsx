import { useProfileUpdateForm } from "./useProfileUpdateForm";
import { Controller } from "react-hook-form";
import { Card, CardHeader } from "@/components/ui/card";
import { RefreshCw, Save } from "lucide-react";
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
 * My Profile Page
 */
export default function Account() {
  const { form, onSubmit, refetch, isProfileLoading, isProfileFetching } =
    useProfileUpdateForm();

  console.log(form.formState.errors);

  return (
    <form onSubmit={onSubmit}>
      <Card className="rounded-sm py-0 gap-0">
        <CardHeader className="px-4 py-3">
          <div className="flex items-end justify-between gap-4">
            <div>
              <h1 className="text-2xl font-bold text-gray-900">Profile</h1>
              <p className="text-sm text-gray-500 mt-0.5">
                Update your profile here
              </p>
            </div>
            <div className="flex items-center gap-2">
              <Button
                size="sm"
                variant="ghost"
                title="Refresh"
                disabled={isProfileLoading || isProfileFetching}
                onClick={() => refetch()}
              >
                <RefreshCw size={14} />
              </Button>
              <Button
                type="submit"
                disabled={
                  form.formState.isSubmitting ||
                  isProfileFetching ||
                  isProfileLoading
                }
              >
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
          {isProfileLoading || isProfileFetching ? (
            <Spinner className="size-6 mx-auto" />
          ) : (
            <FieldGroup className="grid grid-cols-1 gap-4 md:grid-cols-3">
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
            </FieldGroup>
          )}
        </div>
      </Card>
    </form>
  );
}
