<?php

namespace App\Features\GlobalSearch\Services;

use App\Features\GlobalSearch\Interfaces\GlobalSearchRepositoryInterface;
use App\Features\GlobalSearch\Interfaces\GlobalSearchServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class GlobalSearchService implements GlobalSearchServiceInterface
{

	public function __construct(private GlobalSearchRepositoryInterface $searchRepository) {}

	public function paginate(Int $total = 10): LengthAwarePaginator
	{
		return $this->searchRepository->paginate($total);
	}
}
