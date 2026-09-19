<?php

namespace App\Features\Products\Controllers;

use App\Features\Products\Interfaces\ProductServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Products\Resources\ProductCollection;
use Illuminate\Http\Request;

class ProductViewController extends Controller
{
    public function __construct(private ProductServiceInterface $productService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id, Request $request)
    {
        $product = $this->productService->getById($id, $request->query('include-category') == 'yes', $request->query('include-sub-category') == 'yes', $request->query('include-tax') == 'yes', $request->query('include-specification') == 'yes', $request->query('include-image') == 'yes', $request->query('include-video') == 'yes', $request->query('include-color') == 'yes', $request->query('include-price') == 'yes', $request->query('include-stock') == 'yes', $request->query('include-latest-stock') == 'yes', $request->query('include-review') == 'yes');
        return response()->json(["message" => "Product fetched successfully.", "data" => ProductCollection::make($product)], 200);
    }
}
