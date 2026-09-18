<?php

namespace App\Features\Blogs\Controllers;

use App\Features\Blogs\DTO\BlogDTO;
use App\Features\Blogs\Interfaces\BlogServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Blogs\Requests\BlogUpdatePostRequest;
use App\Features\Blogs\Resources\BlogCollection;

class BlogUpdateController extends Controller
{
    public function __construct(private BlogServiceInterface $blogService) {}

    /**
     * Update an blog
     *
     * @param BlogUpdatePostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(BlogUpdatePostRequest $request, $id)
    {
        $blog = $this->blogService->getById($id);
        try {
            //code...
            $updated_blog = $this->blogService->update(
                BlogDTO::fromRequest($request),
                $blog
            );
            return response()->json(["message" => "Blog updated successfully.", "data" => BlogCollection::make($updated_blog)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
