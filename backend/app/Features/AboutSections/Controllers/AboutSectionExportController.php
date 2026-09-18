<?php

namespace App\Features\AboutSections\Controllers;

use App\Http\Controllers\Controller;
use App\Features\AboutSections\Interfaces\AboutSectionServiceInterface;

class AboutSectionExportController extends Controller
{
    public function __construct(private AboutSectionServiceInterface $sectionService) {}

    /**
     * Download all sections as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->sectionService->exportAboutSections();
    }
}
