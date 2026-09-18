<?php

namespace App\Features\PaymentOptions\Exports;

use App\Http\Services\FileStorageService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Spatie\QueryBuilder\QueryBuilder;


class PaymentOptionExport implements FromQuery, WithHeadings, WithMapping
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
			$data->description,
			$data->image ? (new FileStorageService)->publicUrl($data->image) : 'N/A',
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
			'Description',
			'Image',
			'Is Active',
			'User Id',
			'Created At',
		];
	}
}
