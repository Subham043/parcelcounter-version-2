import {
  ArrowLeft,
  Pencil,
  Package,
  CalendarDays,
  Hash,
  Layers3,
  Truck,
  Receipt,
  Search,
  Image as ImageIcon,
} from "lucide-react";

const product = {
  id: 1,
  name: "Test Product",
  slug: "test-product",
  hsn: "test product",
  description: "Test product",
  image_url:
    "http://localhost:8000/s3/public/products/RNpggSoRhGwPm0Yqa2fkfRHig6JMZi3P5PzwNFJP.png",
  is_active: true,
  is_new: false,
  is_on_sale: true,
  is_featured: false,
  min_cart_quantity: 50,
  cart_quantity_interval: 10,
  cart_quantity_specification: "Kg",
  meta_title: "test product",
  meta_description: "test product",
  meta_keywords: "test product",
  user_id: 1,
  categories: [{ id: 1, name: "Test Category", slug: "test-category" }],
  sub_categories: [
    { id: 1, name: "Test Subcategory", slug: "test-subcategory" },
  ],
  taxes: [
    {
      id: 1,
      name: "Test Tax",
      slug: "test-tax",
      value: "5.00",
      is_inter_state_tax: true,
    },
  ],
  created_at: "2026-10-30T04:58:33.000000Z",
  updated_at: "2026-10-30T04:58:33.000000Z",
};

function Field({ label, value }: { label: string; value: React.ReactNode }) {
  return (
    <div className="min-w-0">
      <p className="mb-1.5 text-[11px] font-medium uppercase tracking-wider text-gray-400">
        {label}
      </p>
      <div className="wrap-break-word text-sm font-medium text-gray-800">
        {value || <span className="text-gray-300">Not provided</span>}
      </div>
    </div>
  );
}

function Section({
  title,
  subtitle,
  icon: Icon,
  children,
}: {
  title: string;
  subtitle?: string;
  icon: React.ElementType;
  children: React.ReactNode;
}) {
  return (
    <section className="space-y-5">
      <div className="flex items-start gap-3">
        <div className="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
          <Icon size={17} strokeWidth={1.8} />
        </div>
        <div>
          <h3 className="text-sm font-semibold text-gray-900">{title}</h3>
          {subtitle && (
            <p className="mt-0.5 text-xs text-gray-400">{subtitle}</p>
          )}
        </div>
      </div>
      {children}
    </section>
  );
}

function Status({ label, active }: { label: string; active: boolean }) {
  return (
    <span
      className={`inline-flex items-center gap-1.5 rounded-md border px-2.5 py-1.5 text-xs font-medium ${
        active
          ? "border-green-200 bg-green-50 text-green-700"
          : "border-gray-200 bg-gray-50 text-gray-500"
      }`}
    >
      <span
        className={`h-1.5 w-1.5 rounded-full ${
          active ? "bg-green-500" : "bg-gray-400"
        }`}
      />
      {label}
    </span>
  );
}

function formatDate(value: string) {
  return new Date(value).toLocaleString("en-IN", {
    day: "2-digit",
    month: "short",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
}

export default function ProductInfo() {
  return (
    <div className="space-y-5">
      {/* Page heading */}
      <div className="flex flex-wrap items-center justify-between gap-4">
        <div>
          <div className="mb-3 flex items-center gap-2 text-xs font-medium text-gray-400">
            <ArrowLeft size={14} />
            <span>Inventory</span>
            <span>/</span>
            <span className="text-gray-600">Products</span>
            <span>/</span>
            <span className="text-gray-900">Details</span>
          </div>

          <h1 className="text-2xl font-semibold tracking-tight text-gray-900">
            Product Details
          </h1>
          <p className="mt-1 text-sm text-gray-500">
            View and manage your product information.
          </p>
        </div>

        <button className="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-gray-700">
          <Pencil size={15} />
          Edit Product
        </button>
      </div>

      {/* Single main card */}
      <div className="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        {/* Product overview */}
        <div className="flex flex-col gap-5 bg-linear-to-r from-gray-50 to-white p-5 sm:flex-row sm:items-center sm:p-7">
          <div className="flex h-28 w-28 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-gray-200 bg-white p-3 shadow-sm">
            {product.image_url ? (
              <img
                src={product.image_url}
                alt={product.name}
                className="h-full w-full object-contain"
              />
            ) : (
              <ImageIcon className="h-9 w-9 text-gray-300" />
            )}
          </div>

          <div className="min-w-0 flex-1">
            <div className="flex flex-wrap items-center gap-2">
              <h2 className="text-xl font-semibold text-gray-900">
                {product.name}
              </h2>
              <Status label="Active" active={product.is_active} />
            </div>

            <p className="mt-1 text-sm text-gray-500">{product.slug}</p>

            <div className="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-gray-500">
              <span className="inline-flex items-center gap-1.5">
                <Hash size={13} />
                ID: #{product.id}
              </span>
              <span className="inline-flex items-center gap-1.5">
                <Package size={13} />
                HSN: {product.hsn}
              </span>
            </div>
          </div>

          <div className="flex flex-wrap gap-2 sm:max-w-64 sm:justify-end">
            <Status label="New" active={product.is_new} />
            <Status label="On Sale" active={product.is_on_sale} />
            <Status label="Featured" active={product.is_featured} />
          </div>
        </div>

        <div className="border-t border-gray-100" />

        {/* Information content */}
        <div className="space-y-8 p-5 sm:p-7">
          {/* General */}
          <Section
            title="General Information"
            subtitle="Basic product identification and details"
            icon={Package}
          >
            <div className="grid grid-cols-2 gap-x-6 gap-y-6 rounded-lg bg-gray-50/80 p-4 sm:grid-cols-3 lg:grid-cols-4">
              <Field label="Product Name" value={product.name} />
              <Field label="Product Slug" value={product.slug} />
              <Field label="HSN Code" value={product.hsn} />
              <Field label="Created By" value={`User #${product.user_id}`} />
              <div className="col-span-2 sm:col-span-3 lg:col-span-4">
                <Field label="Brief Description" value={product.description} />
              </div>
            </div>
          </Section>

          <div className="border-t border-gray-100" />

          {/* Classification */}
          <Section
            title="Classification"
            subtitle="Product categories and grouping"
            icon={Layers3}
          >
            <div className="grid gap-5 sm:grid-cols-2">
              <div className="rounded-lg border border-gray-100 p-4">
                <Field
                  label="Categories"
                  value={
                    <div className="mt-2 flex flex-wrap gap-2">
                      {product.categories.map((item) => (
                        <span
                          key={item.id}
                          className="rounded-md border border-blue-100 bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700"
                        >
                          {item.name}
                        </span>
                      ))}
                    </div>
                  }
                />
              </div>
              <div className="rounded-lg border border-gray-100 p-4">
                <Field
                  label="Subcategories"
                  value={
                    <div className="mt-2 flex flex-wrap gap-2">
                      {product.sub_categories.map((item) => (
                        <span
                          key={item.id}
                          className="rounded-md border border-gray-200 bg-gray-50 px-2.5 py-1 text-xs font-medium text-gray-700"
                        >
                          {item.name}
                        </span>
                      ))}
                    </div>
                  }
                />
              </div>
            </div>
          </Section>

          <div className="border-t border-gray-100" />

          {/* Quantity */}
          <Section
            title="Quantity Configuration"
            subtitle="Minimum order quantity and unit settings"
            icon={Truck}
          >
            <div className="grid grid-cols-2 gap-5 rounded-lg bg-gray-50/80 p-4 sm:grid-cols-3">
              <Field
                label="Minimum Cart Quantity"
                value={product.min_cart_quantity}
              />
              <Field
                label="Quantity Interval"
                value={product.cart_quantity_interval}
              />
              <Field
                label="Unit Specification"
                value={product.cart_quantity_specification}
              />
            </div>
          </Section>

          <div className="border-t border-gray-100" />

          {/* Taxes */}
          <Section
            title="Tax Information"
            subtitle="Applicable product tax configurations"
            icon={Receipt}
          >
            <div className="overflow-hidden rounded-lg border border-gray-200">
              <div className="overflow-x-auto">
                <table className="w-full text-left text-sm">
                  <thead className="bg-gray-50 text-xs text-gray-500">
                    <tr>
                      <th className="px-4 py-3 font-medium">Tax Name</th>
                      <th className="px-4 py-3 font-medium">Slug</th>
                      <th className="px-4 py-3 font-medium">Tax Value</th>
                      <th className="px-4 py-3 font-medium">Inter-State Tax</th>
                    </tr>
                  </thead>
                  <tbody className="divide-y divide-gray-100">
                    {product.taxes.map((tax) => (
                      <tr key={tax.id} className="hover:bg-gray-50/70">
                        <td className="px-4 py-3 font-medium text-gray-800">
                          {tax.name}
                        </td>
                        <td className="px-4 py-3 text-gray-500">{tax.slug}</td>
                        <td className="px-4 py-3 font-semibold text-gray-800">
                          {tax.value}%
                        </td>
                        <td className="px-4 py-3">
                          <Status
                            label={
                              tax.is_inter_state_tax
                                ? "Applicable"
                                : "Not Applicable"
                            }
                            active={tax.is_inter_state_tax}
                          />
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </div>
          </Section>

          <div className="border-t border-gray-100" />

          {/* Description */}
          <Section
            title="Product Description"
            subtitle="Full product description"
            icon={Package}
          >
            <div className="rounded-lg bg-gray-50/80 p-4 text-sm leading-6 text-gray-700">
              {product.description}
            </div>
          </Section>

          <div className="border-t border-gray-100" />

          {/* SEO */}
          <Section
            title="SEO Information"
            subtitle="Search engine metadata"
            icon={Search}
          >
            <div className="grid grid-cols-1 gap-5 rounded-lg bg-gray-50/80 p-4 sm:grid-cols-2">
              <Field label="Meta Title" value={product.meta_title} />
              <Field label="Meta Keywords" value={product.meta_keywords} />
              <div className="sm:col-span-2">
                <Field
                  label="Meta Description"
                  value={product.meta_description}
                />
              </div>
            </div>
          </Section>

          <div className="border-t border-gray-100" />

          {/* Record info */}
          <Section
            title="Record Information"
            subtitle="Product creation and modification history"
            icon={CalendarDays}
          >
            <div className="grid grid-cols-1 gap-5 sm:grid-cols-2">
              <Field
                label="Created At"
                value={formatDate(product.created_at)}
              />
              <Field
                label="Last Updated"
                value={formatDate(product.updated_at)}
              />
            </div>
          </Section>
        </div>
      </div>
    </div>
  );
}
