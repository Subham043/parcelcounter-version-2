<?php

namespace App\Features\Banners\Controllers;

use App\Features\Banners\Interfaces\BannerServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Banners\Resources\BannerCollection;

class BannerViewController extends Controller
{
    public function __construct(private BannerServiceInterface $bannerService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $banner = $this->bannerService->getById($id);
        return response()->json(["message" => "Banner fetched successfully.", "data" => BannerCollection::make($banner)], 200);
    }
}
