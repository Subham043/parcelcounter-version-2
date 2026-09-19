<?php

namespace App\Features\Products\Controllers;

use App\Features\Products\Interfaces\ProductServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Products\Resources\ProductCollection;
use Illuminate\Http\Request;

class ProductToggleStatusController extends Controller
{
    public function __construct(private ProductServiceInterface $productService) {}

    /**
     * Toggle the active status of an product.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * This method retrieves the product by the given ID, starts a database transaction,
     * and toggles the 'is_active' status of the product. It returns a JSON response
     * indicating whether the product was active or unactive successfully. In case
     * of an error, it returns a 400 status JSON response with an error message.
     */

    public function index($id, Request $request)
    {
        $product = $this->productService->getById($id, $request->query('include-category') == 'yes', $request->query('include-sub-category') == 'yes', $request->query('include-tax') == 'yes', $request->query('include-specification') == 'yes', $request->query('include-image') == 'yes', $request->query('include-video') == 'yes', $request->query('include-color') == 'yes', $request->query('include-price') == 'yes', $request->query('include-stock') == 'yes', $request->query('include-latest-stock') == 'yes', $request->query('include-review') == 'yes');
        try {
            //code...
            $updated_product = $this->productService->toggleActive($product);
            if ($updated_product->is_active) {
                return response()->json(["message" => "Product is now active.", "data" => ProductCollection::make($updated_product)], 200);
            }
            return response()->json(["message" => "Product is now inactive.", "data" => ProductCollection::make($updated_product)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
