<?php

namespace App\Features\LegalContents\Controllers;

use App\Http\Controllers\Controller;
use App\Features\LegalContents\Interfaces\LegalContentServiceInterface;

class LegalContentExportController extends Controller
{
    public function __construct(private LegalContentServiceInterface $legalContentService) {}

    /**
     * Download all legalContents as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->legalContentService->exportLegalContents();
    }
}
