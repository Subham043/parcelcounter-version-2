<?php

namespace App\Features\ProductVideos\Controllers;

use App\Features\ProductVideos\Interfaces\ProductVideoServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductVideos\Resources\ProductVideoCollection;

class ProductVideoViewController extends Controller
{
    public function __construct(private ProductVideoServiceInterface $videoService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $product_id
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($product_id, $id)
    {
        $video = $this->videoService->getById($product_id, $id);
        return response()->json(["message" => "Product video fetched successfully.", "data" => ProductVideoCollection::make($video)], 200);
    }
}
