import { Card, CardHeader } from "@/components/ui/card";
import {
  Field,
  FieldError,
  FieldGroup,
  FieldLabel,
} from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import { Separator } from "@/components/ui/separator";
import type { ProductFormValuesType } from "@/utils/data/schema/product";
import { ShoppingCart } from "lucide-react";
import { Controller, useFormContext } from "react-hook-form";

function ProductCartForm() {
  const { control } = useFormContext<ProductFormValuesType>();
  return (
    <Card className="rounded-sm py-0 gap-0">
      <CardHeader className="px-4 py-3">
        <div className="flex items-end justify-between gap-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center gap-2">
              <ShoppingCart className="h-4 w-4 text-slate-500" />

              <h2 className="text-sm font-bold tracking-wide text-slate-800">
                Product Cart
              </h2>
            </div>
          </div>
          <div className="flex items-center gap-2">
            <p className="text-xs text-gray-500 mt-0.5">
              product cart specification is managed here
            </p>
          </div>
        </div>
      </CardHeader>
      <Separator orientation="horizontal" className="bg-gray-100" />
      <div className="px-4 py-3">
        <FieldGroup>
          <Controller
            name="min_cart_quantity"
            control={control}
            render={({ field, fieldState }) => (
              <Field data-invalid={fieldState.invalid}>
                <FieldLabel htmlFor="product-form-min-cart-quantity">
                  Minimum Cart Quantity
                </FieldLabel>
                <Input
                  {...field}
                  aria-invalid={fieldState.invalid}
                  placeholder="Enter minimum cart quantity"
                  autoComplete="off"
                  id="product-form-min-cart-quantity"
                  type="number"
                />
                {fieldState.invalid && (
                  <FieldError errors={[fieldState.error]} />
                )}
              </Field>
            )}
          />
          <Controller
            name="cart_quantity_interval"
            control={control}
            render={({ field, fieldState }) => (
              <Field data-invalid={fieldState.invalid}>
                <FieldLabel htmlFor="product-form-cart-quantity-interval">
                  Cart Quantity Interval
                </FieldLabel>
                <Input
                  {...field}
                  aria-invalid={fieldState.invalid}
                  placeholder="Enter cart quantity interval"
                  autoComplete="off"
                  id="product-form-cart-quantity-interval"
                  type="number"
                />
                {fieldState.invalid && (
                  <FieldError errors={[fieldState.error]} />
                )}
              </Field>
            )}
          />
          <Controller
            name="cart_quantity_specification"
            control={control}
            render={({ field, fieldState }) => (
              <Field data-invalid={fieldState.invalid}>
                <FieldLabel htmlFor="product-form-cart-quantity-specification">
                  Cart Quantity Specification
                </FieldLabel>
                <Input
                  {...field}
                  aria-invalid={fieldState.invalid}
                  placeholder="Enter cart quantity specification"
                  autoComplete="off"
                  id="product-form-cart-quantity-specification"
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
  );
}

export default ProductCartForm;
