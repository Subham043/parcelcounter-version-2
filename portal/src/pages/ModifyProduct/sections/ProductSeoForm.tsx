import TagInput from "@/components/TagInput";
import { Card, CardHeader } from "@/components/ui/card";
import {
  Field,
  FieldError,
  FieldGroup,
  FieldLabel,
} from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import {
  InputGroup,
  InputGroupAddon,
  InputGroupText,
  InputGroupTextarea,
} from "@/components/ui/input-group";
import { Separator } from "@/components/ui/separator";
import type { ProductFormValuesType } from "@/utils/data/schema/product";
import { GlobeCheck } from "lucide-react";
import { Controller, useFormContext } from "react-hook-form";

function ProductSeoForm() {
  const { control } = useFormContext<ProductFormValuesType>();
  return (
    <Card className="rounded-sm py-0 gap-0">
      <CardHeader className="px-4 py-3">
        <div className="flex items-end justify-between gap-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center gap-2">
              <GlobeCheck className="h-4 w-4 text-slate-500" />

              <h2 className="text-sm font-bold tracking-wide text-slate-800">
                Product SEO
              </h2>
            </div>
          </div>
          <div className="flex items-center gap-2">
            <p className="text-xs text-gray-500 mt-0.5">
              product seo is managed here
            </p>
          </div>
        </div>
      </CardHeader>
      <Separator orientation="horizontal" className="bg-gray-100" />
      <div className="px-4 py-3">
        <FieldGroup className="grid grid-cols-1 gap-4 md:grid-cols-2">
          <Controller
            name="meta_title"
            control={control}
            render={({ field, fieldState }) => (
              <Field data-invalid={fieldState.invalid}>
                <FieldLabel htmlFor="product-form-meta-title">
                  Meta Title
                </FieldLabel>
                <Input
                  {...field}
                  aria-invalid={fieldState.invalid}
                  placeholder="Enter meta title"
                  autoComplete="off"
                  id="product-form-meta-title"
                />
                {fieldState.invalid && (
                  <FieldError errors={[fieldState.error]} />
                )}
              </Field>
            )}
          />
          <Controller
            name="meta_keywords"
            control={control}
            render={({ field, fieldState }) => (
              <Field data-invalid={fieldState.invalid}>
                <FieldLabel htmlFor="product-form-meta-keywords">
                  Meta Keywords
                </FieldLabel>
                <TagInput value={field.value || []} onChange={field.onChange} />
                {fieldState.invalid && (
                  <FieldError errors={[fieldState.error]} />
                )}
              </Field>
            )}
          />
          <div className="md:col-span-3">
            <Controller
              name="meta_description"
              control={control}
              render={({ field, fieldState }) => (
                <Field data-invalid={fieldState.invalid}>
                  <FieldLabel htmlFor="product-form-meta-description">
                    Meta Description
                  </FieldLabel>
                  <InputGroup>
                    <InputGroupTextarea
                      {...field}
                      id="product-form-meta-description"
                      placeholder="Enter meta description"
                      rows={6}
                      className="min-h-24 resize-none"
                      aria-invalid={fieldState.invalid}
                    />
                    <InputGroupAddon align="block-end">
                      <InputGroupText className="tabular-nums">
                        {field?.value?.length ?? 0}
                        /500 characters
                      </InputGroupText>
                    </InputGroupAddon>
                  </InputGroup>
                  {fieldState.invalid && (
                    <FieldError errors={[fieldState.error]} />
                  )}
                </Field>
              )}
            />
          </div>
        </FieldGroup>
      </div>
    </Card>
  );
}

export default ProductSeoForm;
