<?php

namespace App\Features\Banners\Exports;

use App\Http\Services\FileStorageService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Spatie\QueryBuilder\QueryBuilder;


class BannerExport implements FromQuery, WithHeadings, WithMapping
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
			$data->title ?? 'N/A',
			$data->alt ?? 'N/A',
			$data->desktop_image ? (new FileStorageService)->publicUrl($data->desktop_image) : 'N/A',
			$data->mobile_image ? (new FileStorageService)->publicUrl($data->mobile_image) : 'N/A',
			$data->is_active ? 'Yes' : 'No',
			$data->user_id,
			$data->created_at->format('Y-m-d H:i:s'),
		];
	}

	public function headings(): array
	{
		return [
			'Id',
			'Title',
			'Alt',
			'Desktop Image',
			'Mobile Image',
			'Is Active',
			'User Id',
			'Created At',
		];
	}
}
