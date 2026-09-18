<?php

namespace App\Features\Banners\Controllers;

use App\Features\Banners\Interfaces\BannerServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Banners\Resources\BannerCollection;

class BannerDeleteController extends Controller
{
    public function __construct(private BannerServiceInterface $bannerService) {}

    /**
     * Delete a banner
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $banner = $this->bannerService->getById($id);
        try {
            //code...
            $this->bannerService->delete($banner);
            return response()->json(["message" => "Banner deleted successfully.", "data" => BannerCollection::make($banner)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
