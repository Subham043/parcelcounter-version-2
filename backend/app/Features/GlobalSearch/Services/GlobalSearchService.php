<?php

namespace App\Features\GlobalSearch\Services;

use App\Features\GlobalSearch\DTO\GlobalSearchFilterDTO;
use App\Features\GlobalSearch\Interfaces\GlobalSearchRepositoryInterface;
use App\Features\GlobalSearch\Interfaces\GlobalSearchServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class GlobalSearchService implements GlobalSearchServiceInterface
{

	public function __construct(private GlobalSearchRepositoryInterface $searchRepository) {}

	public function paginate(?GlobalSearchFilterDTO $dto = null): LengthAwarePaginator
	{
		return $this->searchRepository->paginate($dto);
	}
}
