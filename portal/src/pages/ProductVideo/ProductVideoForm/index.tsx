import { Controller } from "react-hook-form";
import { useProductVideoForm } from "./useProductVideoForm";
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
  Dialog,
  DialogClose,
  DialogContent,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog";

/*
 * Product Video Form Dialog
 */
export default function ProductVideoForm({
  product_id,
}: {
  product_id: number;
}) {
  const { form, modal, isLoading, onSubmit, handleClose } = useProductVideoForm(
    { product_id },
  );
  return (
    <Dialog
      open={modal.show}
      onOpenChange={(v) => {
        if (!v) {
          handleClose();
        }
      }}
    >
      <DialogContent>
        <DialogHeader>
          <DialogTitle>{`${modal.type === "create" ? "Create" : "Update"} Product Video`}</DialogTitle>
        </DialogHeader>
        <div>
          {isLoading ? (
            <Spinner className="size-6 mx-auto" />
          ) : (
            <form className="space-y-5" onSubmit={onSubmit}>
              <FieldGroup>
                <Controller
                  name="video"
                  control={form.control}
                  render={({ field, fieldState }) => (
                    <Field data-invalid={fieldState.invalid}>
                      <FieldLabel htmlFor="product-video-form-video">
                        Video URL
                      </FieldLabel>
                      <Input
                        {...field}
                        aria-invalid={fieldState.invalid}
                        placeholder="Enter video url"
                        autoComplete="off"
                        id="product-video-form-video"
                        type="url"
                      />
                      {fieldState.invalid && (
                        <FieldError errors={[fieldState.error]} />
                      )}
                    </Field>
                  )}
                />
              </FieldGroup>
              <DialogFooter>
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
                  <DialogClose
                    render={
                      <Button
                        variant="outline"
                        type="button"
                        className="flex-1"
                      />
                    }
                  >
                    Cancel
                  </DialogClose>
                </div>
              </DialogFooter>
            </form>
          )}
        </div>
      </DialogContent>
    </Dialog>
  );
}
