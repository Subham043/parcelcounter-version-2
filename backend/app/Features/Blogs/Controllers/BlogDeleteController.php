<?php

namespace App\Features\Blogs\Controllers;

use App\Features\Blogs\Interfaces\BlogServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Blogs\Resources\BlogCollection;

class BlogDeleteController extends Controller
{
    public function __construct(private BlogServiceInterface $blogService) {}

    /**
     * Delete a blog
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $blog = $this->blogService->getById($id);
        try {
            //code...
            $this->blogService->delete($blog);
            return response()->json(["message" => "Blog deleted successfully.", "data" => BlogCollection::make($blog)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
