<?php

namespace App\Features\TexteditorImages\Controllers;

use App\Features\TexteditorImages\DTO\TexteditorImageDTO;
use App\Features\TexteditorImages\Interfaces\TexteditorImageServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\TexteditorImages\Requests\TexteditorImagePostRequest;
use App\Features\TexteditorImages\Resources\TexteditorImageCollection;

class TexteditorImageCreateController extends Controller
{

    public function __construct(private TexteditorImageServiceInterface $texteditorImageService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(TexteditorImagePostRequest $request)
    {
        try {
            //code...
            $texteditorImage = $this->texteditorImageService->create(
                TexteditorImageDTO::fromRequest($request),
            );
            return response()->json([
                "message" => "Texteditor image created successfully.",
                "data" => TexteditorImageCollection::make($texteditorImage),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
