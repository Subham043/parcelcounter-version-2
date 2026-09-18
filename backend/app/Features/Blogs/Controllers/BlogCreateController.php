<?php

namespace App\Features\Blogs\Controllers;

use App\Features\Blogs\DTO\BlogDTO;
use App\Features\Blogs\Interfaces\BlogServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Blogs\Requests\BlogCreatePostRequest;
use App\Features\Blogs\Resources\BlogCollection;

class BlogCreateController extends Controller
{

    public function __construct(private BlogServiceInterface $blogService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(BlogCreatePostRequest $request)
    {
        try {
            //code...
            $blog = $this->blogService->create(
                BlogDTO::fromRequest($request),
            );
            return response()->json([
                "message" => "Blog created successfully.",
                "data" => BlogCollection::make($blog),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
