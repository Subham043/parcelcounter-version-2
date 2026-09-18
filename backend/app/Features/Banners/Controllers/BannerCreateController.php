<?php

namespace App\Features\Banners\Controllers;

use App\Features\Banners\DTO\BannerDTO;
use App\Features\Banners\Interfaces\BannerServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Banners\Requests\BannerCreatePostRequest;
use App\Features\Banners\Resources\BannerCollection;

class BannerCreateController extends Controller
{

    public function __construct(private BannerServiceInterface $bannerService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(BannerCreatePostRequest $request)
    {
        try {
            //code...
            $banner = $this->bannerService->create(
                BannerDTO::fromRequest($request),
            );
            return response()->json([
                "message" => "Banner created successfully.",
                "data" => BannerCollection::make($banner),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
