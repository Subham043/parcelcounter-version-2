import EmptyDataBlock from "@/components/EmptyDataBlock";
import { Button } from "@/components/ui/button";
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
import { Plus, Trash2, DollarSign } from "lucide-react";
import {
  Controller,
  useFieldArray,
  useFormContext,
  useWatch,
} from "react-hook-form";

function ProductPriceForm() {
  const { control } = useFormContext<ProductFormValuesType>();

  const { fields, remove, insert } = useFieldArray({
    control,
    name: "prices",
  });

  // Get the CURRENT values of prices
  const prices = useWatch({
    control,
    name: "prices",
  });

  return (
    <Card className="rounded-sm py-0 gap-0">
      <CardHeader className="px-4 py-3">
        <div className="flex items-end justify-between gap-4">
          <div className="w-auto">
            <div className="flex items-center gap-2">
              <DollarSign className="h-4 w-4 text-slate-500" />

              <h2 className="text-sm font-bold tracking-wide text-slate-800">
                Product Prices
              </h2>
            </div>
            <p className="text-xs text-gray-500 mt-0.5">
              product prices are managed here
            </p>
          </div>
          <Button
            type="button"
            size="sm"
            variant="secondary"
            onClick={() =>
              insert(prices.length, {
                min_quantity: 1,
                price: 1,
              })
            }
          >
            <Plus className="mr-1.5 size-4" />
            Add
          </Button>
        </div>
      </CardHeader>
      <Separator orientation="horizontal" className="bg-gray-100" />
      {fields.length > 0 ? (
        <FieldGroup className="max-h-[40dvh] divide-y overflow-y-auto gap-0">
          {fields.map((field, index) => {
            return (
              <div key={field.id} className="pb-3 w-full">
                <div className="space-y-3">
                  <div className="flex items-center justify-between rounded-t-lg border-b bg-muted/40 px-4 py-3">
                    <div className="flex items-center gap-3">
                      <span className="flex size-7 items-center justify-center rounded-md bg-primary/10 text-sm font-semibold text-primary">
                        {index + 1}
                      </span>

                      <h3 className="text-sm font-semibold tracking-tight">
                        Price
                      </h3>
                    </div>

                    <Button
                      type="button"
                      variant="ghost"
                      size="icon"
                      className="size-8 text-muted-foreground transition-colors hover:bg-destructive/10 hover:text-destructive"
                      onClick={() => remove(index)}
                      aria-label={`Remove specification ${index + 1}`}
                    >
                      <Trash2 className="size-4" />
                    </Button>
                  </div>
                  <div className="grid grid-cols-1 gap-4 md:grid-cols-2 px-4">
                    <Controller
                      name={`prices.${index}.min_quantity`}
                      control={control}
                      render={({ field, fieldState }) => (
                        <Field data-invalid={fieldState.invalid}>
                          <FieldLabel
                            htmlFor={`product-price-min-quantity-${index}`}
                          >
                            Min Quantity
                          </FieldLabel>

                          <Input
                            {...field}
                            placeholder="Enter min quantity"
                            autoComplete="off"
                            id={`product-price-min-quantity-${index}`}
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
                      name={`prices.${index}.price`}
                      control={control}
                      render={({ field, fieldState }) => (
                        <Field data-invalid={fieldState.invalid}>
                          <FieldLabel htmlFor={`product-price-price-${index}`}>
                            Price
                          </FieldLabel>

                          <Input
                            {...field}
                            placeholder="Enter price"
                            id={`product-price-price-${index}`}
                            aria-invalid={fieldState.invalid}
                            type="number"
                          />

                          {fieldState.invalid && (
                            <FieldError errors={[fieldState.error]} />
                          )}
                        </Field>
                      )}
                    />
                  </div>
                </div>
              </div>
            );
          })}
        </FieldGroup>
      ) : (
        <EmptyDataBlock
          title="No Prices Found"
          description="No prices are available as of now. Please add now to get started."
        />
      )}
    </Card>
  );
}

export default ProductPriceForm;
