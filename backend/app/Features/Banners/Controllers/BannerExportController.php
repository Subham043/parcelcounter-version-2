<?php

namespace App\Features\Banners\Controllers;

use App\Features\Banners\DTO\BannerFilterDTO;
use App\Http\Controllers\Controller;
use App\Features\Banners\Interfaces\BannerServiceInterface;
use App\Features\Banners\Requests\BannerFilterRequest;

class BannerExportController extends Controller
{
    public function __construct(private BannerServiceInterface $bannerService) {}

    /**
     * Download all banners as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index(BannerFilterRequest $request)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->bannerService->exportBanners(BannerFilterDTO::fromRequest($request));
    }
}
