<?php

namespace App\Features\Categories\Controllers;

use App\Http\Controllers\Controller;
use App\Features\Categories\Interfaces\CategoryServiceInterface;

class CategoryExportController extends Controller
{
    public function __construct(private CategoryServiceInterface $categoryService) {}

    /**
     * Download all categorys as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->categoryService->exportCategories();
    }
}
