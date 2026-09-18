<?php

namespace App\Features\SubCategories\Controllers;

use App\Http\Controllers\Controller;
use App\Features\SubCategories\Interfaces\SubCategoryServiceInterface;

class SubCategoryExportController extends Controller
{
    public function __construct(private SubCategoryServiceInterface $subCategoryService) {}

    /**
     * Download all subCategories as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->subCategoryService->exportSubCategories();
    }
}
