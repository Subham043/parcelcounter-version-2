<?php

namespace App\Features\Banners\Interfaces;

use App\Features\Banners\DTO\BannerDTO;
use App\Features\Banners\Models\Banner;
use Illuminate\Pagination\LengthAwarePaginator;

interface BannerServiceInterface
{
    public function paginate(Int $total = 10): LengthAwarePaginator;
    public function create(BannerDTO $data): Banner;
    public function update(BannerDTO $data, Banner $banner): Banner;
    public function getById(int $id): Banner;
    public function delete(Banner $banner): Banner;
    public function toggleActive(Banner $banner): Banner;
    public function exportBanners(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
