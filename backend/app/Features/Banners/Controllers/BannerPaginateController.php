<?php

namespace App\Features\Banners\Controllers;

use App\Features\Banners\Interfaces\BannerServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Banners\Resources\BannerCollection;
use Illuminate\Http\Request;

class BannerPaginateController extends Controller
{
    public function __construct(private BannerServiceInterface $bannerService) {}

    /**
     * Returns a paginated collection of banners.
     *
     * @param Request $request
     * @return BannerCollection
     */
    public function index(Request $request)
    {
        $data = $this->bannerService->paginate($request->total ?? 10);
        return BannerCollection::collection($data);
    }
}
