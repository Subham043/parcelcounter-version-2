<?php

namespace App\Features\Products\Exports;

use App\Http\Services\FileStorageService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Spatie\QueryBuilder\QueryBuilder;


class ProductExport implements FromQuery, WithHeadings, WithMapping
{

	private QueryBuilder $query;
	public function __construct(QueryBuilder $query)
	{
		$this->query = $query;
	}
	public function query()
	{
		return $this->query; // Using cursor() to avoid memory overload
	}

	public function map($data): array
	{
		return [
			$data->id,
			$data->name,
			$data->slug,
			$data->hsn,
			$data->description_unfiltered,
			$data->brief_description,
			$data->image ? (new FileStorageService)->publicUrl($data->image) : 'N/A',
			$data->categories->pluck('name')->implode(', ') ?? "",
			$data->meta_title ?? 'N/A',
			$data->meta_description ?? 'N/A',
			$data->meta_keywords ?? 'N/A',
			$data->is_active ? 'Yes' : 'No',
			$data->is_new ? 'Yes' : 'No',
			$data->is_on_sale ? 'Yes' : 'No',
			$data->is_featured ? 'Yes' : 'No',
			$data->min_cart_quantity,
			$data->cart_quantity_interval,
			$data->cart_quantity_specification,
			$data->user_id,
			$data->created_at->format('Y-m-d H:i:s'),
		];
	}

	public function headings(): array
	{
		return [
			'Id',
			'Name',
			'Slug',
			'HSN',
			'Description',
			'Brief Description',
			'Image',
			'Category',
			'Meta Title',
			'Meta Description',
			'Meta Keywords',
			'Is Active',
			'Is New',
			'Is On Sale',
			'Is Featured',
			'Min Cart Quantity',
			'Cart Quantity Interval',
			'Cart Quantity Specification',
			'User Id',
			'Created At',
		];
	}
}
