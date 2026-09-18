<?php

namespace App\Features\ProductVideos\Controllers;

use App\Features\ProductVideos\Interfaces\ProductVideoServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductVideos\Resources\ProductVideoCollection;

class ProductVideoDeleteController extends Controller
{
    public function __construct(private ProductVideoServiceInterface $videoService) {}

    /**
     * Delete a video
     *
     * @param int $product_id
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($product_id, $id)
    {
        $video = $this->videoService->getById($product_id, $id);
        try {
            //code...
            $this->videoService->delete($video);
            return response()->json(["message" => "Product video deleted successfully.", "data" => ProductVideoCollection::make($video)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
