<?php

namespace App\Services;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Filters\PostFilter;
use App\Models\Post;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostService {
    
    /**
     * Fetch paginated and filtered posts.
     *
     * @throws \Exception
     */
    public function getAll(array $params, PostFilter $filters): LengthAwarePaginator
    {
        try {
            $perPage = $params['pre_page'] ?? 10;
            $sortBy = $params['sort_by'] ?? 'created_at';
            $sortOrder = $params['sort_order'] ?? 'desc';

            return $filters
                ->apply(Post::query())
                ->orderBy($sortBy, $sortOrder)
                ->paginate($perPage);

        } catch (\Throwable $e){
            throw new Exception('Failed to fetch data:' . $e->getMessage(), 500);
        }
    }

    public function store(array $data): Post
    {
        try {

            return Post::create($data);

        } catch (\Throwable $e) {

            throw new Exception('Failed to create post: ' . $e->getMessage());
        }
    }

    public function show(string $id): Post
    {
        try {
            $post = Post::findOrFail($id);
            return $post;

        } catch (ModelNotFoundException $e) {

            throw new Exception('Post not found', 404);
        }
    }

    public function update(Post $post, array $data): Post
    {
        try {
            $post->update($data);
            return $post;

        } catch (\Throwable $e) {

            throw new Exception('Failed to update post: ' . $e->getMessage());
        }
    }

    public function destroy(string $id): void
    {
        try {
            $post = Post::findOrFail($id);
            $post->delete();

        } catch (\Throwable $e) {
            
            throw new Exception('Failed to delete post: ' . $e->getMessage());
        }
    }


}