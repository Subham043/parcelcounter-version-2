<?php

namespace App\Features\Blogs\Controllers;

use App\Features\Blogs\Interfaces\BlogServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Blogs\Resources\BlogCollection;

class BlogSlugController extends Controller
{
    public function __construct(private BlogServiceInterface $blogService) {}

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $blog = $this->blogService->getBySlug($slug);
        return response()->json(["message" => "Blog fetched successfully.", "data" => BlogCollection::make($blog)], 200);
    }
}
