<?php

namespace App\Features\ProductVideos\Controllers;

use App\Features\ProductVideos\DTO\ProductVideoFilterDTO;
use App\Features\ProductVideos\Interfaces\ProductVideoServiceInterface;
use App\Features\ProductVideos\Requests\ProductVideoFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\ProductVideos\Resources\ProductVideoCollection;

class ProductVideoPaginateController extends Controller
{
    public function __construct(private ProductVideoServiceInterface $videoService) {}

    /**
     * Returns a paginated collection of videos.
     *
     * @param int $product_id
     * @param ProductVideoFilterRequest $request
     * @return ProductVideoCollection
     */
    public function index($product_id, ProductVideoFilterRequest $request)
    {
        $data = $this->videoService->paginate($product_id, ProductVideoFilterDTO::fromRequest($request));
        return ProductVideoCollection::collection($data);
    }
}
