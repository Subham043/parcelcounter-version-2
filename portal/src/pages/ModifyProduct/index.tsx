import { useProductForm } from "./sections/useProductForm";
import { FormProvider } from "react-hook-form";
import type { ProductFormValuesType } from "@/utils/data/schema/product";
import { Spinner } from "@/components/ui/spinner";
import ProductMainForm from "./sections/ProductMainForm";
import ProductSeoForm from "./sections/ProductSeoForm";
import ProductCartForm from "./sections/ProductCartForm";
import ProductImagesForm from "./sections/ProductImagesForm";
import ProductVideoForm from "./sections/ProductVideoForm";
import ProductSpecificationForm from "./sections/ProductSpecificationForm";
import ProductPriceForm from "./sections/ProductPriceForm";
import ProductColorForm from "./sections/ProductColorForm";
import ProductStockForm from "./sections/ProductStockForm";

function ModifyProduct() {
  const { form, data, isLoading, onSubmit } = useProductForm();
  return (
    <div className="space-y-6 pt-5">
      <FormProvider<ProductFormValuesType> {...form}>
        <form onSubmit={onSubmit}>
          {isLoading ? (
            <div className="p-4">
              <Spinner className="size-6 mx-auto" />
            </div>
          ) : (
            <div className="grid grid-cols-1 gap-4 md:grid-cols-6">
              <div className="md:col-span-4 space-y-5">
                <ProductMainForm image_url={data?.image_url || undefined} />
                <ProductPriceForm />
                <ProductStockForm />
                <ProductSpecificationForm />
                <ProductSeoForm />
              </div>
              <div className="md:col-span-2 space-y-5">
                <ProductCartForm />
                <ProductColorForm />
                <ProductImagesForm images={data?.images ?? []} />
                <ProductVideoForm />
              </div>
            </div>
          )}
        </form>
      </FormProvider>
    </div>
  );
}

export default ModifyProduct;
