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
import { format } from "date-fns";
import { Plus, Trash2, Layers } from "lucide-react";
import {
  Controller,
  useFieldArray,
  useFormContext,
  useWatch,
} from "react-hook-form";

function ProductStockForm() {
  const { control } = useFormContext<ProductFormValuesType>();

  const { fields, remove, insert } = useFieldArray({
    control,
    name: "stocks",
  });

  // Get the CURRENT values of stocks
  const stocks = useWatch({
    control,
    name: "stocks",
  });

  return (
    <Card className="rounded-sm py-0 gap-0">
      <CardHeader className="px-4 py-3">
        <div className="flex items-end justify-between gap-4">
          <div className="w-auto">
            <div className="flex items-center gap-2">
              <Layers className="h-4 w-4 text-slate-500" />

              <h2 className="text-sm font-bold tracking-wide text-slate-800">
                Product Stocks
              </h2>
            </div>
            <p className="text-xs text-gray-500 mt-0.5">
              product stocks are managed here
            </p>
          </div>
          <Button
            type="button"
            size="sm"
            variant="secondary"
            onClick={() =>
              insert(stocks.length, {
                purchase_stock: 1,
                quantity: 1,
                purchased_at: new Date(),
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
                        Stock
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
                  <div className="grid grid-cols-1 gap-4 md:grid-cols-3 px-4">
                    <Controller
                      name={`stocks.${index}.purchase_stock`}
                      control={control}
                      render={({ field, fieldState }) => (
                        <Field data-invalid={fieldState.invalid}>
                          <FieldLabel
                            htmlFor={`product-price-purchase-stock-${index}`}
                          >
                            Purchase price
                          </FieldLabel>

                          <Input
                            {...field}
                            placeholder="Enter purchase price"
                            autoComplete="off"
                            id={`product-price-purchase-stock-${index}`}
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
                      name={`stocks.${index}.quantity`}
                      control={control}
                      render={({ field, fieldState }) => (
                        <Field data-invalid={fieldState.invalid}>
                          <FieldLabel
                            htmlFor={`product-price-quantity-${index}`}
                          >
                            Quantity
                          </FieldLabel>

                          <Input
                            {...field}
                            placeholder="Enter quantity"
                            autoComplete="off"
                            id={`product-price-quantity-${index}`}
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
                      name={`stocks.${index}.purchased_at`}
                      control={control}
                      render={({ field, fieldState }) => (
                        <Field data-invalid={fieldState.invalid}>
                          <FieldLabel
                            htmlFor={`product-price-purchased-date-${index}`}
                          >
                            Purchased Date
                          </FieldLabel>

                          <Input
                            value={format(field.value, "yyyy-MM-dd")}
                            onChange={(e) => {
                              field.onChange(new Date(e.target.value));
                            }}
                            placeholder="Enter purchased date"
                            autoComplete="off"
                            id={`product-price-purchased-date-${index}`}
                            aria-invalid={fieldState.invalid}
                            type="date"
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
          title="No Stocks Found"
          description="No stocks are available as of now. Please add now to get started."
        />
      )}
    </Card>
  );
}

export default ProductStockForm;
