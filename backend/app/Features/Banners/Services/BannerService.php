<?php

namespace App\Features\Banners\Services;

use App\Features\Banners\DTO\BannerDTO;
use App\Features\Banners\Exports\BannerExport;
use App\Features\Banners\Interfaces\BannerRepositoryInterface;
use App\Features\Banners\Interfaces\BannerServiceInterface;
use App\Features\Banners\Models\Banner;
use App\Http\Enums\Guards;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BannerService implements BannerServiceInterface
{

	public function __construct(private BannerRepositoryInterface $bannerRepository) {}

	public function paginate(Int $total = 10): LengthAwarePaginator
	{
		return $this->bannerRepository->paginate($total);
	}

	public function getById(Int $id): Banner
	{
		return $this->bannerRepository->getById($id);
	}

	public function create(BannerDTO $data): Banner
	{
		return DB::transaction(function () use ($data) {
			return $this->bannerRepository->create([...$data->toArray(), 'user_id' => auth(Guards::API->value())->user()->id]);
		});
	}

	public function update(BannerDTO $data, Banner $banner): Banner
	{
		return DB::transaction(function () use ($data, $banner) {
			$desktop_image = $banner->desktop_image;
			if($data->desktop_image){
				$desktop_image = $data->desktop_image;
			}
			$mobile_image = $banner->mobile_image;
			if($data->mobile_image){
				$mobile_image = $data->mobile_image;
			}
			return $this->bannerRepository->update($banner, [...$data->toArray(), 'desktop_image' => $desktop_image, 'mobile_image' => $mobile_image]);
		});
	}

	public function toggleActive(Banner $banner): Banner
	{
		return DB::transaction(function () use ($banner) {
			return $this->bannerRepository->update($banner, ['is_active' => !$banner->is_active]);
		});
	}

	public function delete(Banner $banner): Banner
	{
		return DB::transaction(function () use ($banner) {
			return $this->bannerRepository->delete($banner);
		});
	}

	public function exportBanners(): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return Excel::download(new BannerExport($this->bannerRepository->query()), 'banners.xlsx');
	}
}
