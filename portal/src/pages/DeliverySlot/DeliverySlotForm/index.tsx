import { Controller } from "react-hook-form";
import { useDeliverySlotForm } from "./useDeliverySlotForm";
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
 * DeliverySlot Form Drawer
 */
export default function DeliverySlotForm() {
  const { form, modal, isLoading, onSubmit, handleClose } =
    useDeliverySlotForm();
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
      <DrawerContent>
        <DrawerHeader>
          <DrawerTitle>{`${modal.type === "create" ? "Create" : "Update"} Delivery Slot`}</DrawerTitle>
        </DrawerHeader>
        <div className="flex-1 p-4">
          {isLoading ? (
            <Spinner className="size-6 mx-auto" />
          ) : (
            <form
              className="space-y-5 h-full flex flex-col"
              onSubmit={onSubmit}
            >
              <div className="flex-1 scroll-fade overflow-y-auto">
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
                    name="start_time"
                    control={form.control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid}>
                        <FieldLabel htmlFor="charge-form-start_time">
                          Start Time
                        </FieldLabel>
                        <Input
                          {...field}
                          aria-invalid={fieldState.invalid}
                          placeholder="Enter start time"
                          type="time"
                          autoComplete="off"
                          id="charge-form-start_time"
                        />
                        {fieldState.invalid && (
                          <FieldError errors={[fieldState.error]} />
                        )}
                      </Field>
                    )}
                  />
                  <Controller
                    name="end_time"
                    control={form.control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid}>
                        <FieldLabel htmlFor="charge-form-end_time">
                          End Time
                        </FieldLabel>
                        <Input
                          {...field}
                          aria-invalid={fieldState.invalid}
                          placeholder="Enter end time"
                          type="time"
                          autoComplete="off"
                          id="charge-form-end_time"
                        />
                        {fieldState.invalid && (
                          <FieldError errors={[fieldState.error]} />
                        )}
                      </Field>
                    )}
                  />
                  <Controller
                    name="is_cod_allowed"
                    control={form.control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid}>
                        <div className="flex items-center space-x-2">
                          <Switch
                            id="is_cod_allowed"
                            checked={field.value}
                            onCheckedChange={field.onChange}
                          />
                          <FieldLabel htmlFor="is_cod_allowed">
                            Is COD Allowed?
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
              <DrawerFooter className="py-0">
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
