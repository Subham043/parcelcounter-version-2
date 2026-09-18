<?php

namespace App\Features\Charges\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Spatie\QueryBuilder\QueryBuilder;


class ChargeExport implements FromQuery, WithHeadings, WithMapping
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
			$data->value,
			$data->is_percentage ? 'Yes' : 'No',
			$data->include_charges_for_cart_price_below ?? 'N/A',
			$data->is_active ? 'Yes' : 'No',
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
			'Value',
			'Is Percentage',
			'Include Charges For Cart Price Below',
			'Is Active',
			'User Id',
			'Created At',
		];
	}
}
