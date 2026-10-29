<?php

namespace App\Features\Products\Controllers;

use App\Features\Products\DTO\ProductFilterDTO;
use App\Http\Controllers\Controller;
use App\Features\Products\Interfaces\ProductServiceInterface;
use App\Features\Products\Requests\ProductFilterRequest;

class ProductExportController extends Controller
{
    public function __construct(private ProductServiceInterface $productService) {}

    /**
     * Download all subCategories as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index(ProductFilterRequest $request)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->productService->exportProducts(ProductFilterDTO::fromRequest($request));
    }
}
