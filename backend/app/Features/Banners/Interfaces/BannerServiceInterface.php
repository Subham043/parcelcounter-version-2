<?php

namespace App\Features\Banners\Interfaces;

use App\Features\Banners\DTO\BannerDTO;
use App\Features\Banners\DTO\BannerFilterDTO;
use App\Features\Banners\Models\Banner;
use Illuminate\Pagination\LengthAwarePaginator;

interface BannerServiceInterface
{
    public function paginate(?BannerFilterDTO $dto = null): LengthAwarePaginator;
    public function create(BannerDTO $data): Banner;
    public function update(BannerDTO $data, Banner $banner): Banner;
    public function getById(int $id): Banner;
    public function delete(Banner $banner): Banner;
    public function toggleActive(Banner $banner): Banner;
    public function exportBanners(?BannerFilterDTO $dto = null): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
