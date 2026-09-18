<?php

namespace App\Features\Blogs\Exports;

use App\Http\Services\FileStorageService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Spatie\QueryBuilder\QueryBuilder;


class BlogExport implements FromQuery, WithHeadings, WithMapping
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
			$data->heading,
			$data->description_unfiltered,
			$data->image ? (new FileStorageService)->publicUrl($data->image) : 'N/A',
			$data->meta_title ?? 'N/A',
			$data->meta_description ?? 'N/A',
			$data->meta_keywords ?? 'N/A',
			$data->is_popular ? 'Yes' : 'No',
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
			'Heading',
			'Description',
			'Image',
			'Meta Title',
			'Meta Description',
			'Meta Keywords',
			'Is Popular',
			'Is Active',
			'User Id',
			'Created At',
		];
	}
}
