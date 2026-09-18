<?php

namespace App\Features\ProductVideos\Controllers;

use App\Features\ProductVideos\DTO\ProductVideoDTO;
use App\Features\ProductVideos\Interfaces\ProductVideoServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductVideos\Requests\ProductVideoPostRequest;
use App\Features\ProductVideos\Resources\ProductVideoCollection;

class ProductVideoUpdateController extends Controller
{
    public function __construct(private ProductVideoServiceInterface $videoService) {}

    /**
     * Update an video
     *
     * @param int $product_id
     * @param ProductVideoPostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($product_id, $id, ProductVideoPostRequest $request)
    {
        $video = $this->videoService->getById($product_id, $id);
        try {
            //code...
            $updated_video = $this->videoService->update(
                ProductVideoDTO::fromRequest($request),
                $video
            );
            return response()->json(["message" => "Product video updated successfully.", "data" => ProductVideoCollection::make($updated_video)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
