<?php

namespace App\Features\Banners\Controllers;

use App\Features\Banners\DTO\BannerDTO;
use App\Features\Banners\Interfaces\BannerServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Banners\Requests\BannerUpdatePostRequest;
use App\Features\Banners\Resources\BannerCollection;

class BannerUpdateController extends Controller
{
    public function __construct(private BannerServiceInterface $bannerService) {}

    /**
     * Update an banner
     *
     * @param BannerUpdatePostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(BannerUpdatePostRequest $request, $id)
    {
        $banner = $this->bannerService->getById($id);
        try {
            //code...
            $updated_banner = $this->bannerService->update(
                BannerDTO::fromRequest($request),
                $banner
            );
            return response()->json(["message" => "Banner updated successfully.", "data" => BannerCollection::make($updated_banner)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
