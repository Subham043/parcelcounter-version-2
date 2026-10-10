import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader } from "@/components/ui/card";
import { FieldError } from "@/components/ui/field";
import { Separator } from "@/components/ui/separator";
import type { ProductFormValuesType } from "@/utils/data/schema/product";
import type { ProductType } from "@/utils/types";
import { CheckCircle2, Eye, Image, Upload, X } from "lucide-react";
import { useCallback, useRef } from "react";
import { useFormContext, useWatch } from "react-hook-form";

function formatFileSize(size: number) {
  if (size < 1024) {
    return `${size} B`;
  }

  if (size < 1024 * 1024) {
    return `${(size / 1024).toFixed(1)} KB`;
  }

  if (size < 1024 * 1024 * 1024) {
    return `${(size / (1024 * 1024)).toFixed(1)} MB`;
  }

  return `${(size / (1024 * 1024 * 1024)).toFixed(1)} GB`;
}

function FileIcon({ attachmentUrl }: { attachmentUrl: string }) {
  return (
    <div className="relative flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-500 space-y-1">
      <img src={attachmentUrl} className="h-full w-full object-cover" />
    </div>
  );
}

function AttachmentItem({
  attachmentUrl,
  name,
}: {
  attachmentUrl: string;
  name: string;
}) {
  return (
    <div className="group flex items-center gap-3 rounded-lg border border-slate-200 bg-white px-3 py-3 transition-colors hover:border-slate-300 hover:bg-slate-50/50">
      <div className="relative">
        <FileIcon attachmentUrl={attachmentUrl} />
      </div>

      <div className="min-w-0 flex-1">
        <p className="truncate text-sm font-semibold text-slate-800">{name}</p>
      </div>

      <div className="flex shrink-0 items-center gap-1">
        <Button
          type="button"
          variant="ghost"
          size="icon"
          className="h-8 w-8 text-slate-400 hover:text-slate-700"
          nativeButton={false}
          render={<a href={attachmentUrl} target="_blank" />}
        >
          <Eye className="h-4 w-4" />
        </Button>
      </div>
    </div>
  );
}

export default function ProductImagesForm({
  images,
}: {
  images: ProductType["images"];
}) {
  const fileInputRef = useRef<HTMLInputElement>(null);

  const { control, setValue, formState } =
    useFormContext<ProductFormValuesType>();

  const attachmentFiles = useWatch({
    name: "images",
    control: control,
  });

  const handleFile = useCallback(
    (files: File[]) => {
      const existingFiles = attachmentFiles || [];
      setValue(
        "images",
        [...existingFiles, ...files.map((item) => ({ image: item }))],
        {
          shouldValidate: true,
          shouldDirty: true,
          shouldTouch: true,
        },
      );
    },
    [setValue, attachmentFiles],
  );

  const handleFileChange = useCallback(
    (event: React.ChangeEvent<HTMLInputElement>) => {
      const files = event.target.files;

      if (files) {
        handleFile(Array.from(files));
      }
    },
    [handleFile],
  );

  const handleDrop = useCallback(
    (event: React.DragEvent<HTMLDivElement>) => {
      event.preventDefault();

      const files = event.dataTransfer.files;

      if (files) {
        handleFile(Array.from(files));
      }
    },
    [handleFile],
  );

  const removeFile = useCallback(
    (index: number) => {
      setValue(
        "images",
        attachmentFiles?.filter((_, i) => i !== index),
        {
          shouldValidate: true,
          shouldDirty: true,
        },
      );

      if (fileInputRef.current) {
        fileInputRef.current.value = "";
      }
    },
    [setValue, attachmentFiles],
  );

  return (
    <Card className="flex flex-col overflow-hidden border-slate-200 gap-0 p-0 rounded-sm">
      {/* Header */}
      <CardHeader className="px-4 py-3">
        <div className="flex items-end justify-between gap-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center gap-2">
              <Image className="h-4 w-4 text-slate-500" />

              <h2 className="text-sm font-bold tracking-wide text-slate-800">
                Product Images
              </h2>

              {attachmentFiles?.length > 0 && (
                <Badge
                  variant="secondary"
                  className="h-5 min-w-5 justify-center rounded-full bg-slate-100 px-1.5 text-[11px] font-semibold text-slate-600"
                >
                  {attachmentFiles?.length ?? 0}
                </Badge>
              )}
            </div>
          </div>
          <div className="flex items-center gap-2">
            <p className="text-xs text-gray-500 mt-0.5">
              Manage product images are managed here
            </p>
          </div>
        </div>
      </CardHeader>
      <Separator orientation="horizontal" className="bg-gray-100" />

      <CardContent className="flex flex-1 flex-col p-5">
        {/* Dropzone */}
        <div
          className="flex h-36.5 cursor-pointer flex-col items-center justify-center rounded-xl border border-dashed border-slate-300 bg-slate-50/40 transition-colors hover:border-emerald-300 hover:bg-emerald-50/20"
          onClick={() => fileInputRef.current?.click()}
          onDragOver={(event) => {
            event.preventDefault();
          }}
          onDrop={handleDrop}
        >
          <input
            ref={fileInputRef}
            type="file"
            className="hidden"
            onChange={handleFileChange}
            disabled={formState.isSubmitting}
            multiple
          />
          <div className="mb-3 flex h-11 w-11 items-center justify-center rounded-full bg-emerald-100 text-emerald-500">
            <Upload className="h-5 w-5" />
          </div>

          <p className="text-sm text-slate-500">
            <button
              className="font-semibold text-emerald-600 underline underline-offset-2 hover:text-emerald-700"
              onClick={(event) => {
                event.stopPropagation();
                fileInputRef.current?.click();
              }}
              type="button"
            >
              Choose a file
            </button>{" "}
            or drag it here
          </p>

          <p className="mt-1 text-xs text-slate-400">
            Supported formats: JPG, PNG, WebP, JPEG (Max 2MB)
          </p>
        </div>
        {formState.errors.images?.message && (
          <FieldError errors={[formState.errors.images]} />
        )}

        {attachmentFiles?.length > 0 && (
          <div className="space-y-1 mt-1">
            {attachmentFiles?.map((item: { image: File }, index) => (
              <div
                className="flex w-full max-w-full items-center gap-3 rounded-lg border border-slate-200 bg-white px-3 py-2"
                onClick={(event) => event.stopPropagation()}
                key={`attachement-files-${index}`}
              >
                <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                  <img
                    src={URL.createObjectURL(item.image)}
                    className="h-full w-full object-cover"
                  />
                </div>

                <div className="min-w-0 flex-1">
                  <p className="truncate text-sm font-medium text-slate-700">
                    {item.image.name}
                  </p>

                  <p className="text-xs text-slate-400">
                    {formatFileSize(item.image.size)}
                  </p>

                  {formState.errors.images?.[index]?.image?.message && (
                    <FieldError
                      errors={[formState.errors.images?.[index]?.image]}
                      className="text-xs"
                    />
                  )}
                </div>

                <button
                  type="button"
                  onClick={(e) => {
                    e.stopPropagation();
                    removeFile(index);
                  }}
                  className="flex h-8 w-8 shrink-0 items-center justify-center rounded-md text-slate-400 hover:bg-slate-100 hover:text-slate-700 cursor-pointer"
                >
                  <X className="h-4 w-4" />
                </button>
              </div>
            ))}
          </div>
        )}

        {images.length > 0 && (
          <>
            {/* Documents header */}
            <div className="mt-6 mb-3 flex items-center justify-between">
              <p className="text-xs font-semibold text-slate-500">
                Attached Images
              </p>

              <p className="text-xs font-semibold text-slate-500">
                Total images: {images.length}
              </p>
            </div>

            {/* Files */}
            <div className="space-y-3 mb-3 min-h-0 max-h-[50dvh] overflow-y-auto">
              {images.map((item, index) => (
                <AttachmentItem
                  key={item.id}
                  attachmentUrl={item.image_url}
                  name={item.image_title ?? `Image ${index + 1}`}
                />
              ))}
            </div>

            {/* Footer */}
            <div className="mt-auto -mx-5 -mb-5 border-t border-slate-100 bg-slate-50/70 px-4 py-3">
              <div className="flex items-center gap-1.5 text-xs text-emerald-600">
                <CheckCircle2 className="h-3.5 w-3.5 fill-emerald-100" />
                All uploads scanned for malware & viruses
              </div>
            </div>
          </>
        )}
      </CardContent>
    </Card>
  );
}
