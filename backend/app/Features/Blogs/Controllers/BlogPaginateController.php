<?php

namespace App\Features\Blogs\Controllers;

use App\Features\Blogs\DTO\BlogFilterDTO;
use App\Features\Blogs\Interfaces\BlogServiceInterface;
use App\Features\Blogs\Requests\BlogFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\Blogs\Resources\BlogCollection;

class BlogPaginateController extends Controller
{
    public function __construct(private BlogServiceInterface $blogService) {}

    /**
     * Returns a paginated collection of blogs.
     *
     * @param BlogFilterRequest $request
     * @return BlogCollection
     */
    public function index(BlogFilterRequest $request)
    {
        $data = $this->blogService->paginate(BlogFilterDTO::fromRequest($request));
        return BlogCollection::collection($data);
    }
}
