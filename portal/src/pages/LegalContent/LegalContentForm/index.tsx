import { Controller } from "react-hook-form";
import { useLegalContentForm } from "./useLegalContentForm";
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
import {
  InputGroup,
  InputGroupAddon,
  InputGroupText,
  InputGroupTextarea,
} from "@/components/ui/input-group";
import RichTextEditor from "@/components/RichTextEditor";
import TagInput from "@/components/TagInput";

/*
 * LegalContent Form Drawer
 */
export default function LegalContentForm() {
  const { form, modal, isLoading, onSubmit, handleClose } =
    useLegalContentForm();
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
      <DrawerContent className="w-[50vw] h-full flex flex-col">
        <DrawerHeader className="shrink-0">
          <DrawerTitle>{`${modal.type === "create" ? "Create" : "Update"} Legal Content`}</DrawerTitle>
        </DrawerHeader>
        <div className="min-h-0 flex-1 px-4 py-4">
          {isLoading ? (
            <Spinner className="size-6 mx-auto" />
          ) : (
            <form
              className="space-y-5 flex h-full min-h-0 flex-col"
              onSubmit={onSubmit}
            >
              <div className="scroll-fade min-h-0 flex-1 overflow-y-auto">
                <FieldGroup className="grid grid-cols-1 gap-4 md:grid-cols-3">
                  <Controller
                    name="name"
                    control={form.control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid}>
                        <FieldLabel htmlFor="legal-content-form-name">
                          Name
                        </FieldLabel>
                        <Input
                          {...field}
                          aria-invalid={fieldState.invalid}
                          placeholder="Enter name"
                          autoComplete="off"
                          id="legal-content-form-name"
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
                        <FieldLabel htmlFor="legal-content-form-slug">
                          Slug
                        </FieldLabel>
                        <Input
                          {...field}
                          aria-invalid={fieldState.invalid}
                          placeholder="Enter slug"
                          autoComplete="off"
                          id="legal-content-form-slug"
                        />
                        {fieldState.invalid && (
                          <FieldError errors={[fieldState.error]} />
                        )}
                      </Field>
                    )}
                  />
                  <Controller
                    name="heading"
                    control={form.control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid}>
                        <FieldLabel htmlFor="legal-content-form-heading">
                          Heading
                        </FieldLabel>
                        <Input
                          {...field}
                          aria-invalid={fieldState.invalid}
                          placeholder="Enter heading"
                          autoComplete="off"
                          id="legal-content-form-heading"
                        />
                        {fieldState.invalid && (
                          <FieldError errors={[fieldState.error]} />
                        )}
                      </Field>
                    )}
                  />
                  <div className="md:col-span-3">
                    <Controller
                      name="description"
                      control={form.control}
                      render={({ field, fieldState }) => (
                        <Field data-invalid={fieldState.invalid}>
                          <FieldLabel htmlFor="feature-form-description">
                            Description
                          </FieldLabel>
                          <RichTextEditor
                            value={(field.value as string) ?? ""}
                            onChange={field.onChange}
                            onChangePlainText={(value) =>
                              form.setValue("description_unfiltered", value)
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
                <FieldGroup className="grid grid-cols-1 gap-4 md:grid-cols-2 mt-4">
                  <Controller
                    name="meta_title"
                    control={form.control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid}>
                        <FieldLabel htmlFor="legal-content-form-meta-title">
                          Meta Title
                        </FieldLabel>
                        <Input
                          {...field}
                          aria-invalid={fieldState.invalid}
                          placeholder="Enter meta title"
                          autoComplete="off"
                          id="legal-content-form-meta-title"
                        />
                        {fieldState.invalid && (
                          <FieldError errors={[fieldState.error]} />
                        )}
                      </Field>
                    )}
                  />
                  <Controller
                    name="meta_keywords"
                    control={form.control}
                    render={({ field, fieldState }) => (
                      <Field data-invalid={fieldState.invalid}>
                        <FieldLabel htmlFor="legal-content-form-meta-keywords">
                          Meta Keywords
                        </FieldLabel>
                        <TagInput
                          value={field.value || []}
                          onChange={field.onChange}
                        />
                        {fieldState.invalid && (
                          <FieldError errors={[fieldState.error]} />
                        )}
                      </Field>
                    )}
                  />
                  <div className="md:col-span-2">
                    <Controller
                      name="meta_description"
                      control={form.control}
                      render={({ field, fieldState }) => (
                        <Field data-invalid={fieldState.invalid}>
                          <FieldLabel htmlFor="legal-content-form-meta-description">
                            Meta Description
                          </FieldLabel>
                          <InputGroup>
                            <InputGroupTextarea
                              {...field}
                              id="legal-content-form-meta-description"
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
                  <div className="md:col-span-2">
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
                  </div>
                </FieldGroup>
              </div>
              <DrawerFooter className="shrink-0 px-0 py-0">
                <div className="flex items-center gap-1">
                  <Button
                    type="submit"
                    disabled={form.formState.isSubmitting}
                    className="min-w-20"
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
                        className="min-w-20"
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
