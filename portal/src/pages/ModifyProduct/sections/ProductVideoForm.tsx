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
import { Plus, Trash2, Video } from "lucide-react";
import {
  Controller,
  useFieldArray,
  useFormContext,
  useWatch,
} from "react-hook-form";

function ProductVideoForm() {
  const { control } = useFormContext<ProductFormValuesType>();

  const { fields, remove, insert } = useFieldArray({
    control,
    name: "videos",
  });

  // Get the CURRENT values of videos
  const videos = useWatch({
    control,
    name: "videos",
  });

  return (
    <Card className="rounded-sm py-0 gap-0">
      <CardHeader className="px-4 py-3">
        <div className="flex items-end justify-between gap-4">
          <div className="w-auto">
            <div className="flex items-center gap-2">
              <Video className="h-4 w-4 text-slate-500" />

              <h2 className="text-sm font-bold tracking-wide text-slate-800">
                Product Video
              </h2>
            </div>
            <p className="text-xs text-gray-500 mt-0.5">
              product video is managed here
            </p>
          </div>
          <Button
            type="button"
            size="sm"
            variant="secondary"
            onClick={() =>
              insert(videos.length, {
                video: "",
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
              <div key={field.id} className="px-4 py-3">
                <Controller
                  name={`videos.${index}.video`}
                  control={control}
                  render={({ field, fieldState }) => (
                    <Field data-invalid={fieldState.invalid} className="gap-1">
                      <div className="flex items-center justify-between">
                        <FieldLabel htmlFor={`product-video-${index}`}>
                          {index + 1}. Video URL
                        </FieldLabel>
                        <Button
                          type="button"
                          variant="ghost"
                          size="icon"
                          className="text-destructive hover:bg-destructive/10 hover:text-destructive"
                          onClick={() => remove(index)}
                        >
                          <Trash2 className="size-4" />
                        </Button>
                      </div>

                      <Input
                        {...field}
                        placeholder="Enter video url"
                        autoComplete="off"
                        id={`product-video-${index}`}
                        aria-invalid={fieldState.invalid}
                      />

                      {fieldState.invalid && (
                        <FieldError errors={[fieldState.error]} />
                      )}
                    </Field>
                  )}
                />
              </div>
            );
          })}
        </FieldGroup>
      ) : (
        <EmptyDataBlock
          title="No Videos Found"
          description="No videos are available as of now. Please add now to get started."
        />
      )}
    </Card>
  );
}

export default ProductVideoForm;
