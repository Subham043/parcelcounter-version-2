import CategoryMultiSelect from "@/components/CategoryMultiSelect";
import RichTextEditor from "@/components/RichTextEditor";
import SingleImageInput from "@/components/SingleImageInput";
import SubCategoryMultiSelect from "@/components/SubCategoryMultiSelect";
import TaxMultiSelect from "@/components/TaxMultiSelect";
import { Button } from "@/components/ui/button";
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
import { Spinner } from "@/components/ui/spinner";
import { Switch } from "@/components/ui/switch";
import type { ProductFormValuesType } from "@/utils/data/schema/product";
import { page_routes } from "@/utils/routes/page_routes";
import { Save } from "lucide-react";
import { Controller, useFormContext, useWatch } from "react-hook-form";
import { Link } from "react-router";

function ProductMainForm({ image_url }: { image_url: string | undefined }) {
  const { control, formState, setValue } =
    useFormContext<ProductFormValuesType>();
  const is_create = useWatch({
    name: "is_create",
    control: control,
  });
  return (
    <Card className="rounded-sm py-0 gap-0">
      <CardHeader className="px-4 py-3">
        <div className="flex items-end justify-between gap-4">
          <div>
            <h1 className="text-2xl font-bold text-gray-900">
              {is_create ? "Create" : "Update"} Product
            </h1>
            <p className="text-sm text-gray-500 mt-0.5">
              Product is managed here
            </p>
          </div>
          <div className="flex items-center gap-2">
            <Button
              type="button"
              variant="outline"
              nativeButton={false}
              render={<Link to={page_routes.products.link} />}
            >
              Cancel
            </Button>
            <Button type="submit" disabled={formState.isSubmitting}>
              {formState.isSubmitting ? (
                <Spinner data-icon="inline-start" />
              ) : (
                <Save size={16} data-icon="inline-start" />
              )}
              {formState.isSubmitting ? "Saving..." : "Save"}
            </Button>
          </div>
        </div>
      </CardHeader>
      <Separator orientation="horizontal" className="bg-gray-100" />
      <div className="px-4 py-3">
        <FieldGroup className="grid grid-cols-1 gap-4 md:grid-cols-3">
          <Controller
            name="name"
            control={control}
            render={({ field, fieldState }) => (
              <Field data-invalid={fieldState.invalid}>
                <FieldLabel htmlFor="product-form-name">Name</FieldLabel>
                <Input
                  {...field}
                  aria-invalid={fieldState.invalid}
                  placeholder="Enter name"
                  autoComplete="off"
                  id="product-form-name"
                />
                {fieldState.invalid && (
                  <FieldError errors={[fieldState.error]} />
                )}
              </Field>
            )}
          />
          <Controller
            name="slug"
            control={control}
            render={({ field, fieldState }) => (
              <Field data-invalid={fieldState.invalid}>
                <FieldLabel htmlFor="product-form-slug">Slug</FieldLabel>
                <Input
                  {...field}
                  aria-invalid={fieldState.invalid}
                  placeholder="Enter slug"
                  autoComplete="off"
                  id="product-form-slug"
                />
                {fieldState.invalid && (
                  <FieldError errors={[fieldState.error]} />
                )}
              </Field>
            )}
          />
          <Controller
            name="hsn"
            control={control}
            render={({ field, fieldState }) => (
              <Field data-invalid={fieldState.invalid}>
                <FieldLabel htmlFor="product-form-hsn">HSN</FieldLabel>
                <Input
                  {...field}
                  aria-invalid={fieldState.invalid}
                  placeholder="Enter HSN"
                  autoComplete="off"
                  id="product-form-hsn"
                />
                {fieldState.invalid && (
                  <FieldError errors={[fieldState.error]} />
                )}
              </Field>
            )}
          />
          <Controller
            name="category"
            control={control}
            render={({ field, fieldState }) => (
              <Field data-invalid={fieldState.invalid}>
                <FieldLabel htmlFor="product-form-category">
                  Category
                </FieldLabel>
                <CategoryMultiSelect
                  value={field.value as { label: string; value: number }[]}
                  onChange={field.onChange}
                />
                {fieldState.invalid && (
                  <FieldError errors={[fieldState.error]} />
                )}
              </Field>
            )}
          />
          <Controller
            name="sub_category"
            control={control}
            render={({ field, fieldState }) => (
              <Field data-invalid={fieldState.invalid}>
                <FieldLabel htmlFor="product-form-sub_category">
                  Sub-Category
                </FieldLabel>
                <SubCategoryMultiSelect
                  value={field.value as { label: string; value: number }[]}
                  onChange={field.onChange}
                />
                {fieldState.invalid && (
                  <FieldError errors={[fieldState.error]} />
                )}
              </Field>
            )}
          />
          <Controller
            name="tax"
            control={control}
            render={({ field, fieldState }) => (
              <Field data-invalid={fieldState.invalid}>
                <FieldLabel htmlFor="product-form-tax">Tax</FieldLabel>
                <TaxMultiSelect
                  value={field.value as { label: string; value: number }[]}
                  onChange={field.onChange}
                />
                {fieldState.invalid && (
                  <FieldError errors={[fieldState.error]} />
                )}
              </Field>
            )}
          />
          <div className="md:col-span-3">
            <Controller
              name="image"
              control={control}
              render={({ field, fieldState }) => {
                return (
                  <Field
                    data-invalid={fieldState.invalid}
                    className="max-w-full min-w-0"
                  >
                    <FieldLabel htmlFor="product-form-image">Image</FieldLabel>
                    <SingleImageInput
                      image={image_url || undefined}
                      value={field.value as File | undefined}
                      onChange={field.onChange}
                    />
                    {fieldState.invalid && (
                      <FieldError errors={[fieldState.error]} />
                    )}
                  </Field>
                );
              }}
            />
          </div>
          <div className="md:col-span-3">
            <Controller
              name="brief_description"
              control={control}
              render={({ field, fieldState }) => (
                <Field data-invalid={fieldState.invalid}>
                  <FieldLabel htmlFor="product-form-brief-description">
                    Brief Description
                  </FieldLabel>
                  <InputGroup>
                    <InputGroupTextarea
                      {...field}
                      id="product-form-brief-description"
                      placeholder="Enter brief description"
                      rows={6}
                      className="min-h-24 resize-none"
                      aria-invalid={fieldState.invalid}
                      maxLength={500}
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
          <div className="md:col-span-3">
            <Controller
              name="description"
              control={control}
              render={({ field, fieldState }) => (
                <Field data-invalid={fieldState.invalid}>
                  <FieldLabel htmlFor="product-form-description">
                    Description
                  </FieldLabel>
                  <RichTextEditor
                    value={(field.value as string) ?? ""}
                    onChange={field.onChange}
                    onChangePlainText={(value) =>
                      setValue("description_unfiltered", value)
                    }
                    placeholder="Enter description"
                  />
                  {fieldState.invalid && (
                    <FieldError errors={[fieldState.error]} />
                  )}
                </Field>
              )}
            />
          </div>
        </FieldGroup>
        <FieldGroup className="grid grid-cols-1 gap-4 md:grid-cols-4 mt-5">
          <Controller
            name="is_active"
            control={control}
            render={({ field, fieldState }) => (
              <Field data-invalid={fieldState.invalid}>
                <div className="flex items-center space-x-2">
                  <Switch
                    id="is_active"
                    checked={field.value}
                    onCheckedChange={field.onChange}
                  />
                  <FieldLabel htmlFor="is_active">Is Active?</FieldLabel>
                </div>
                {fieldState.invalid && (
                  <FieldError errors={[fieldState.error]} />
                )}
              </Field>
            )}
          />
          <Controller
            name="is_new"
            control={control}
            render={({ field, fieldState }) => (
              <Field data-invalid={fieldState.invalid}>
                <div className="flex items-center space-x-2">
                  <Switch
                    id="is_new"
                    checked={field.value}
                    onCheckedChange={field.onChange}
                  />
                  <FieldLabel htmlFor="is_new">Is New?</FieldLabel>
                </div>
                {fieldState.invalid && (
                  <FieldError errors={[fieldState.error]} />
                )}
              </Field>
            )}
          />
          <Controller
            name="is_on_sale"
            control={control}
            render={({ field, fieldState }) => (
              <Field data-invalid={fieldState.invalid}>
                <div className="flex items-center space-x-2">
                  <Switch
                    id="is_on_sale"
                    checked={field.value}
                    onCheckedChange={field.onChange}
                  />
                  <FieldLabel htmlFor="is_on_sale">Is On Sale?</FieldLabel>
                </div>
                {fieldState.invalid && (
                  <FieldError errors={[fieldState.error]} />
                )}
              </Field>
            )}
          />
          <Controller
            name="is_featured"
            control={control}
            render={({ field, fieldState }) => (
              <Field data-invalid={fieldState.invalid}>
                <div className="flex items-center space-x-2">
                  <Switch
                    id="is_featured"
                    checked={field.value}
                    onCheckedChange={field.onChange}
                  />
                  <FieldLabel htmlFor="is_featured">Is Featured?</FieldLabel>
                </div>
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

export default ProductMainForm;
