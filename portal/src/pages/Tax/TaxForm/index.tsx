import { Controller } from "react-hook-form";
import { useTaxForm } from "./useTaxForm";
import { Spinner } from "@/components/ui/spinner";
import {
  Field,
  FieldError,
  FieldGroup,
  FieldLabel,
} from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import {
  Drawer,
  DrawerClose,
  DrawerContent,
  DrawerFooter,
  DrawerHeader,
  DrawerTitle,
} from "@/components/ui/drawer";
import { Switch } from "@/components/ui/switch";

/*
 * Tax Form Drawer
 */
export default function TaxForm() {
  const { form, modal, isLoading, onSubmit, handleClose } = useTaxForm();
  return (
    <Drawer
      open={modal.show}
      onOpenChange={(v) => {
        if (!v) {
          handleClose();
        }
      }}
      swipeDirection="right"
    >
      <DrawerContent className="h-full flex flex-col">
        <DrawerHeader className="shrink-0">
          <DrawerTitle>{`${modal.type === "create" ? "Create" : "Update"} Tax`}</DrawerTitle>
        </DrawerHeader>
        <div className="min-h-0 flex-1 p-4">
          {isLoading ? (
            <Spinner className="size-6 mx-auto" />
          ) : (
            <form
              className="space-y-5 flex h-full min-h-0 flex-col"
              onSubmit={onSubmit}
            >
              <div className="scroll-fade min-h-0 flex-1 overflow-y-auto">
                <FieldGroup>
                  <Controller
                    name="name"
                    control={form.control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid}>
                        <FieldLabel htmlFor="charge-form-name">Name</FieldLabel>
                        <Input
                          {...field}
                          aria-invalid={fieldState.invalid}
                          placeholder="Enter name"
                          autoComplete="off"
                          id="charge-form-name"
                        />
                        {fieldState.invalid && (
                          <FieldError errors={[fieldState.error]} />
                        )}
                      </Field>
                    )}
                  />
                  <Controller
                    name="slug"
                    control={form.control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid}>
                        <FieldLabel htmlFor="charge-form-slug">Slug</FieldLabel>
                        <Input
                          {...field}
                          aria-invalid={fieldState.invalid}
                          placeholder="Enter slug"
                          autoComplete="off"
                          id="charge-form-slug"
                        />
                        {fieldState.invalid && (
                          <FieldError errors={[fieldState.error]} />
                        )}
                      </Field>
                    )}
                  />
                  <Controller
                    name="value"
                    control={form.control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid}>
                        <FieldLabel htmlFor="charge-form-value">
                          Value
                        </FieldLabel>
                        <Input
                          {...field}
                          aria-invalid={fieldState.invalid}
                          placeholder="Enter value"
                          type="number"
                          id="charge-form-value"
                        />
                        {fieldState.invalid && (
                          <FieldError errors={[fieldState.error]} />
                        )}
                      </Field>
                    )}
                  />
                  <Controller
                    name="is_inter_state_tax"
                    control={form.control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid}>
                        <div className="flex items-center space-x-2">
                          <Switch
                            id="is_inter_state_tax"
                            checked={field.value}
                            onCheckedChange={field.onChange}
                          />
                          <FieldLabel htmlFor="is_inter_state_tax">
                            Is Inter State Tax?
                          </FieldLabel>
                        </div>
                        {fieldState.invalid && (
                          <FieldError errors={[fieldState.error]} />
                        )}
                      </Field>
                    )}
                  />
                  <Controller
                    name="is_active"
                    control={form.control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid}>
                        <div className="flex items-center space-x-2">
                          <Switch
                            id="is_active"
                            checked={field.value}
                            onCheckedChange={field.onChange}
                          />
                          <FieldLabel htmlFor="is_active">
                            Is Active?
                          </FieldLabel>
                        </div>
                        {fieldState.invalid && (
                          <FieldError errors={[fieldState.error]} />
                        )}
                      </Field>
                    )}
                  />
                </FieldGroup>
              </div>
              <DrawerFooter className="shrink-0 p-0">
                <div className="flex items-center justify-between gap-1">
                  <Button
                    type="submit"
                    disabled={form.formState.isSubmitting}
                    className="flex-1"
                  >
                    {form.formState.isSubmitting && (
                      <Spinner className="size-5" data-icon="inline-start" />
                    )}
                    {form.formState.isSubmitting ? "Saving..." : "Save"}
                  </Button>
                  <DrawerClose
                    render={
                      <Button
                        variant="outline"
                        type="button"
                        className="flex-1"
                      />
                    }
                  >
                    Cancel
                  </DrawerClose>
                </div>
              </DrawerFooter>
            </form>
          )}
        </div>
      </DrawerContent>
    </Drawer>
  );
}
