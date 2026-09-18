<?php

namespace App\Features\Blogs\Controllers;

use App\Features\Blogs\Interfaces\BlogServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Blogs\Resources\BlogCollection;
use Illuminate\Http\Request;

class BlogPaginateController extends Controller
{
    public function __construct(private BlogServiceInterface $blogService) {}

    /**
     * Returns a paginated collection of blogs.
     *
     * @param Request $request
     * @return BlogCollection
     */
    public function index(Request $request)
    {
        $data = $this->blogService->paginate($request->total ?? 10);
        return BlogCollection::collection($data);
    }
}
