<?php

namespace App\Http\Controllers\Api;

use App\Filters\PostFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePostRequest;
use App\Http\Requests\Api\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request , PostFilter $filters)
    {
        try {

            $posts = $this->postService->getAll($request->all(), $filters);
            return $this->successResponse('Fetched data successfully', PostResource::collection($posts));

        } catch (\Throwable $e) {

            Log::error('PostService Error: ' . $e->getMessage());
            return $this->errorResponse('An error occurred while fetching posts.', 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        try {

            $post = $this->postService->store($request->validated());
            return $this->successResponse('Post created successfully', new PostResource($post), 201);

        } catch (\Throwable $e) {

            Log::error('PostService Store Error: ' . $e->getMessage());
            return $this->errorResponse('Failed to create post', 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $post = $this->postService->show($id);
            return $this->successResponse('Post fetched successfully', new PostResource($post));

        } catch (\Throwable $e) {
            Log::error('PostService Show Error: ' . $e->getMessage());
            return $this->errorResponse($e->getMessage(), $e->getCode() ?: 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        try {

            $post = $this->postService->update($post, $request->validated());
            return $this->successResponse('Post updated successfully', new PostResource($post));

        } catch (\Throwable $e) {

            Log::error('PostService Update Error: ' . $e->getMessage());
            return $this->errorResponse('Failed to update post', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id){
        try {

            $this->postService->destroy($id);
            return $this->successResponse('Post deleted successfully');

        } catch (\Throwable $e) {
            
            Log::error('PostService Destroy Error: ' . $e->getMessage());
            return $this->errorResponse('Failed to delete post', 500);
        }
    }
}
