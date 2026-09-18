<?php

namespace App\Features\ProductVideos\Controllers;

use App\Features\ProductVideos\DTO\ProductVideoDTO;
use App\Features\ProductVideos\Interfaces\ProductVideoServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductVideos\Requests\ProductVideoPostRequest;
use App\Features\ProductVideos\Resources\ProductVideoCollection;

class ProductVideoCreateController extends Controller
{

    public function __construct(private ProductVideoServiceInterface $videoService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param int $product_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index($product_id, ProductVideoPostRequest $request)
    {
        try {
            //code...
            $video = $this->videoService->create(
                ProductVideoDTO::fromRequest($request),
                $product_id,
            );
            return response()->json([
                "message" => "Product video created successfully.",
                "data" => ProductVideoCollection::make($video),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
