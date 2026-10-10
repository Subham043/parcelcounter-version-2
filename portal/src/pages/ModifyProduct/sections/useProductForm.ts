// hooks/useProductForm.ts
import { useCallback, useEffect } from "react";
import { useForm, type Resolver, type UseFormReturn } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { productFormSchema, type ProductFormValuesType } from "@/utils/data/schema/product";
import { useProductCreateMutation, useProductUpdateMutation } from "@/utils/data/mutation/product";
import { useProductQuery } from "@/utils/data/query/product";
import { handleFormServerErrors } from "@/utils/helper";
import { useParams } from "react-router";

const FORM_DEFAULT_VALUES: ProductFormValuesType = {
    is_create: true,
    name: "",
    slug: "",
    hsn: undefined,
    brief_description: "",
    description: "",
    description_unfiltered: "",
    min_cart_quantity: 1,
    cart_quantity_interval: 1,
    cart_quantity_specification: "Kg",
    meta_title: undefined,
    meta_description: undefined,
    meta_keywords: [],
    is_active: true,
    is_new: false,
    is_on_sale: false,
    is_featured: false,
    image: undefined,
    category: [],
    sub_category: [],
    tax: [],
    specifications: [],
    prices: [],
    stocks: [],
    colors: [],
    videos: [],
    images: [],
}

export function useProductForm() {

    const { id: productId } = useParams<{ id: string | undefined }>();
    const isUpdate = !!productId;

    const { data, isLoading, isFetching, isRefetching } = useProductQuery(
        isUpdate ? Number(productId) : 0,
        isUpdate,
        { includeCategory: true, includeSubCategory: true, includeTax: true, includeSpecification: true, includeImage: true, includeVideo: true, includeColor: true, includePrice: true, includeStock: true, includeLatestStock: false, includeReview: false },
        true,
    );

    const createProductMutation = useProductCreateMutation();
    const updateProductMutation = useProductUpdateMutation(isUpdate ? Number(productId) : 0);

    const form = useForm({
        resolver: yupResolver(productFormSchema) as Resolver<ProductFormValuesType>,
        defaultValues: FORM_DEFAULT_VALUES,
    });

    useEffect(() => {

        if (!isUpdate) {
            form.reset(FORM_DEFAULT_VALUES);
            return;
        }

        if (isUpdate && data) {
            form.reset({
                name: data?.name || "",
                slug: data?.slug || "",
                hsn: data?.hsn || undefined,
                brief_description: data?.brief_description || "",
                description: data?.description || "",
                description_unfiltered: data?.description_unfiltered || "",
                min_cart_quantity: data?.min_cart_quantity || 1,
                cart_quantity_interval: data?.cart_quantity_interval || 1,
                cart_quantity_specification: data?.cart_quantity_specification || "Kg",
                meta_title: data?.meta_title || undefined,
                meta_description: data?.meta_description || undefined,
                meta_keywords: data?.meta_keywords?.split(",") || [] as unknown as string[],
                is_active: data?.is_active || true,
                is_new: data?.is_new || true,
                is_on_sale: data?.is_on_sale || true,
                is_featured: data?.is_featured || true,
                category: data?.categories?.map((category) => ({
                    label: category.name,
                    value: category.id,
                })) || [],
                sub_category: data?.sub_categories?.map((subCategory) => ({
                    label: subCategory.name,
                    value: subCategory.id,
                })) || [],
                tax: data?.taxes?.map((tax) => ({
                    label: `${tax.name} (${tax.value}%)`,
                    value: tax.id,
                })) || [],
                specifications: data?.specifications?.map((specification) => ({
                    title: specification.title,
                    description: specification.description,
                })) || [],
                prices: data?.prices?.map((price) => ({
                    min_quantity: price.min_quantity,
                    price: price.price,
                })) || [],
                stocks: data?.stocks?.map((stock) => ({
                    purchase_stock: stock.purchase_stock,
                    quantity: stock.quantity,
                    purchased_at: new Date(stock.purchased_at),
                })) || [],
                colors: data?.colors?.map((color) => ({
                    name: color.name,
                    code: color.code,
                })) || [],
                videos: data?.videos?.map((video) => ({
                    video: video.video,
                })) || [],
                images: [],
                is_create: false
            });
        }
    }, [isUpdate, data, form]);

    const handleClose = useCallback(() => {
        form.reset(FORM_DEFAULT_VALUES);
    }, [form.reset]);

    const onSubmit = useCallback(
        (event: React.FormEvent<HTMLFormElement>) => {
            form.handleSubmit(async (values) => {
                if (isUpdate) {
                    await updateProductMutation.mutateAsync(values, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ProductFormValuesType>);
                        },
                    });
                } else {
                    await createProductMutation.mutateAsync({ ...values, }, {
                        onSuccess: () => {
                            handleClose();
                        },
                        onError: (error) => {
                            handleFormServerErrors(error, form as UseFormReturn<ProductFormValuesType>);
                        },
                    });
                }
            })(event);
        },
        [isUpdate, form.handleSubmit, createProductMutation.mutateAsync, updateProductMutation.mutateAsync, handleClose],
    );

    return {
        form,
        isUpdate,
        data,
        isLoading: isLoading || isFetching || isRefetching,
        onSubmit,
    };
}
