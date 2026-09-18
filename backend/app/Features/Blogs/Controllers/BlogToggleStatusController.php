<?php

namespace App\Features\Blogs\Controllers;

use App\Features\Blogs\Interfaces\BlogServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Blogs\Resources\BlogCollection;

class BlogToggleStatusController extends Controller
{
    public function __construct(private BlogServiceInterface $blogService) {}

    /**
     * Toggle the active status of an blog.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * This method retrieves the blog by the given ID, starts a database transaction,
     * and toggles the 'is_active' status of the blog. It returns a JSON response
     * indicating whether the blog was active or unactive successfully. In case
     * of an error, it returns a 400 status JSON response with an error message.
     */

    public function index($id)
    {
        $blog = $this->blogService->getById($id);
        try {
            //code...
            $updated_blog = $this->blogService->toggleActive($blog);
            if ($updated_blog->is_active) {
                return response()->json(["message" => "Blog is now active.", "data" => BlogCollection::make($updated_blog)], 200);
            }
            return response()->json(["message" => "Blog is now inactive.", "data" => BlogCollection::make($updated_blog)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
