<?php

namespace App\Features\Blogs\Controllers;

use App\Features\Blogs\Interfaces\BlogServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Blogs\Resources\BlogCollection;

class BlogViewController extends Controller
{
    public function __construct(private BlogServiceInterface $blogService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $blog = $this->blogService->getById($id);
        return response()->json(["message" => "Blog fetched successfully.", "data" => BlogCollection::make($blog)], 200);
    }
}
