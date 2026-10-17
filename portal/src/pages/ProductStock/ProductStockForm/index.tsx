import { Controller } from "react-hook-form";
import { useProductStockForm } from "./useProductStockForm";
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
import { format } from "date-fns";

/*
 * Product Stock Form Drawer
 */
export default function ProductStockForm({
  product_id,
}: {
  product_id: number;
}) {
  const { form, modal, isLoading, onSubmit, handleClose } = useProductStockForm(
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
          <DrawerTitle>{`${modal.type === "create" ? "Create" : "Update"} Product Stock`}</DrawerTitle>
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
                    name="purchase_stock"
                    control={form.control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid}>
                        <FieldLabel htmlFor="product-stock-form-purchase-stock">
                          Purchase price
                        </FieldLabel>

                        <Input
                          {...field}
                          placeholder="Enter purchase price"
                          autoComplete="off"
                          id="product-stock-form-purchase-stock"
                          aria-invalid={fieldState.invalid}
                          type="number"
                          min={1}
                        />

                        {fieldState.invalid && (
                          <FieldError errors={[fieldState.error]} />
                        )}
                      </Field>
                    )}
                  />
                  <Controller
                    name="quantity"
                    control={form.control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid}>
                        <FieldLabel htmlFor="product-stock-form-quantity">
                          Quantity
                        </FieldLabel>

                        <Input
                          {...field}
                          placeholder="Enter quantity"
                          autoComplete="off"
                          id="product-stock-form-quantity"
                          aria-invalid={fieldState.invalid}
                          type="number"
                          min={1}
                        />

                        {fieldState.invalid && (
                          <FieldError errors={[fieldState.error]} />
                        )}
                      </Field>
                    )}
                  />
                  <Controller
                    name="purchased_at"
                    control={form.control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid}>
                        <FieldLabel htmlFor="product-stock-form-purchased-date">
                          Purchased Date
                        </FieldLabel>

                        <Input
                          value={format(field.value, "yyyy-MM-dd")}
                          onChange={(e) => {
                            field.onChange(new Date(e.target.value));
                          }}
                          placeholder="Enter purchased date"
                          autoComplete="off"
                          id="product-stock-form-purchased-date"
                          aria-invalid={fieldState.invalid}
                          type="date"
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
