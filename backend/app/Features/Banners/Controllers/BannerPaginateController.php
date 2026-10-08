<?php

namespace App\Features\Banners\Controllers;

use App\Features\Banners\DTO\BannerFilterDTO;
use App\Features\Banners\Interfaces\BannerServiceInterface;
use App\Features\Banners\Requests\BannerFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\Banners\Resources\BannerCollection;

class BannerPaginateController extends Controller
{
    public function __construct(private BannerServiceInterface $bannerService) {}

    /**
     * Returns a paginated collection of banners.
     *
     * @param BannerFilterRequest $request
     * @return BannerCollection
     */
    public function index(BannerFilterRequest $request)
    {
        $data = $this->bannerService->paginate(BannerFilterDTO::fromRequest($request));
        return BannerCollection::collection($data);
    }
}
