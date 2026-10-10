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
import { Plus, Trash2, Paintbrush } from "lucide-react";
import {
  Controller,
  useFieldArray,
  useFormContext,
  useWatch,
} from "react-hook-form";

function ProductColorForm() {
  const { control } = useFormContext<ProductFormValuesType>();

  const { fields, remove, insert } = useFieldArray({
    control,
    name: "colors",
  });

  // Get the CURRENT values of colors
  const colors = useWatch({
    control,
    name: "colors",
  });

  return (
    <Card className="rounded-sm py-0 gap-0">
      <CardHeader className="px-4 py-3">
        <div className="flex items-end justify-between gap-4">
          <div className="w-auto">
            <div className="flex items-center gap-2">
              <Paintbrush className="h-4 w-4 text-slate-500" />

              <h2 className="text-sm font-bold tracking-wide text-slate-800">
                Product Colors
              </h2>
            </div>
            <p className="text-xs text-gray-500 mt-0.5">
              product colors are managed here
            </p>
          </div>
          <Button
            type="button"
            size="sm"
            variant="secondary"
            onClick={() =>
              insert(colors.length, {
                name: "",
                code: "#000000",
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
                        Color
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
                  <Controller
                    name={`colors.${index}.name`}
                    control={control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid} className="px-4">
                        <FieldLabel htmlFor={`product-color-name-${index}`}>
                          Name
                        </FieldLabel>

                        <Input
                          {...field}
                          placeholder="Enter name"
                          autoComplete="off"
                          id={`product-color-name-${index}`}
                          aria-invalid={fieldState.invalid}
                          type="text"
                        />

                        {fieldState.invalid && (
                          <FieldError errors={[fieldState.error]} />
                        )}
                      </Field>
                    )}
                  />
                  <Controller
                    name={`colors.${index}.code`}
                    control={control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid} className="px-4">
                        <FieldLabel htmlFor={`product-color-code-${index}`}>
                          Code
                        </FieldLabel>

                        <Input
                          {...field}
                          placeholder="Enter color code"
                          autoComplete="off"
                          id={`product-color-code-${index}`}
                          aria-invalid={fieldState.invalid}
                          type="color"
                        />

                        {fieldState.invalid && (
                          <FieldError errors={[fieldState.error]} />
                        )}
                      </Field>
                    )}
                  />
                </div>
              </div>
            );
          })}
        </FieldGroup>
      ) : (
        <EmptyDataBlock
          title="No Colors Found"
          description="No colors are available as of now. Please add now to get started."
        />
      )}
    </Card>
  );
}

export default ProductColorForm;
