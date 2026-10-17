import { Controller } from "react-hook-form";
import { useProductColorForm } from "./useProductColorForm";
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

/*
 * Product Color Form Drawer
 */
export default function ProductColorForm({
  product_id,
}: {
  product_id: number;
}) {
  const { form, modal, isLoading, onSubmit, handleClose } = useProductColorForm(
    { product_id },
  );
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
        <DrawerHeader className="shrink-0 px-3.5">
          <DrawerTitle>{`${modal.type === "create" ? "Create" : "Update"} Product Color`}</DrawerTitle>
        </DrawerHeader>
        <div className="min-h-0 flex-1 p-3">
          {isLoading ? (
            <Spinner className="size-6 mx-auto" />
          ) : (
            <form
              className="space-y-5 flex h-full min-h-0 flex-col"
              onSubmit={onSubmit}
            >
              <div className="scroll-fade min-h-0 flex-1 overflow-y-auto px-0.5">
                <FieldGroup>
                  <Controller
                    name="name"
                    control={form.control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid}>
                        <FieldLabel htmlFor="product-specification-form-name">
                          Title
                        </FieldLabel>
                        <Input
                          {...field}
                          aria-invalid={fieldState.invalid}
                          placeholder="Enter name"
                          autoComplete="off"
                          id="product-specification-form-name"
                        />
                        {fieldState.invalid && (
                          <FieldError errors={[fieldState.error]} />
                        )}
                      </Field>
                    )}
                  />
                  <Controller
                    name="code"
                    control={form.control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid}>
                        <FieldLabel htmlFor="product-specification-form-code">
                          Title
                        </FieldLabel>
                        <Input
                          {...field}
                          aria-invalid={fieldState.invalid}
                          placeholder="Enter code"
                          id="product-specification-form-code"
                          type="color"
                        />
                        {fieldState.invalid && (
                          <FieldError errors={[fieldState.error]} />
                        )}
                      </Field>
                    )}
                  />
                </FieldGroup>
              </div>
              <DrawerFooter className="shrink-0 p-0 px-0.5">
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
