<?php

namespace App\Features\Blogs\Controllers;

use App\Http\Controllers\Controller;
use App\Features\Blogs\Interfaces\BlogServiceInterface;

class BlogExportController extends Controller
{
    public function __construct(private BlogServiceInterface $blogService) {}

    /**
     * Download all blogs as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->blogService->exportBlogs();
    }
}
