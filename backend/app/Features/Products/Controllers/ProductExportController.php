<?php

namespace App\Features\Products\Controllers;

use App\Http\Controllers\Controller;
use App\Features\Products\Interfaces\ProductServiceInterface;

class ProductExportController extends Controller
{
    public function __construct(private ProductServiceInterface $productService) {}

    /**
     * Download all subCategories as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->productService->exportProducts();
    }
}
