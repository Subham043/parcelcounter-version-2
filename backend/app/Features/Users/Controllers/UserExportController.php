<?php

namespace App\Features\Users\Controllers;

use App\Features\Users\DTO\UserFilterDTO;
use App\Http\Controllers\Controller;
use App\Features\Users\Interfaces\UserServiceInterface;
use App\Features\Users\Requests\UserFilterRequest;

class UserExportController extends Controller
{
    public function __construct(private UserServiceInterface $userService) {}

    /**
     * Download all users as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index(UserFilterRequest $request)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->userService->exportUsers(UserFilterDTO::fromRequest($request));
    }
}
