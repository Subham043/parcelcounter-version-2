<?php

namespace App\Features\ProductVideos\Controllers;

use App\Features\ProductVideos\Interfaces\ProductVideoServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductVideos\Resources\ProductVideoCollection;
use Illuminate\Http\Request;

class ProductVideoPaginateController extends Controller
{
    public function __construct(private ProductVideoServiceInterface $videoService) {}

    /**
     * Returns a paginated collection of videos.
     *
     * @param int $product_id
     * @param Request $request
     * @return ProductVideoCollection
     */
    public function index($product_id, Request $request)
    {
        $data = $this->videoService->paginate($product_id, $request->total ?? 10);
        return ProductVideoCollection::collection($data);
    }
}
