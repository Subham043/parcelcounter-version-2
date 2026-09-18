<?php

namespace App\Features\Banners\Controllers;

use App\Features\Banners\Interfaces\BannerServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Banners\Resources\BannerCollection;

class BannerToggleStatusController extends Controller
{
    public function __construct(private BannerServiceInterface $bannerService) {}

    /**
     * Toggle the active status of an banner.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * This method retrieves the banner by the given ID, starts a database transaction,
     * and toggles the 'is_active' status of the banner. It returns a JSON response
     * indicating whether the banner was active or unactive successfully. In case
     * of an error, it returns a 400 status JSON response with an error message.
     */

    public function index($id)
    {
        $banner = $this->bannerService->getById($id);
        try {
            //code...
            $updated_banner = $this->bannerService->toggleActive($banner);
            if ($updated_banner->is_active) {
                return response()->json(["message" => "Banner is now active.", "data" => BannerCollection::make($updated_banner)], 200);
            }
            return response()->json(["message" => "Banner is now inactive.", "data" => BannerCollection::make($updated_banner)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
