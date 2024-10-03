<?php
namespace App\Services;

use App\Models\Blog;

class BlogService
{
    public function getPost($id) {
        try {
            return json_encode([
                'status' => 'success',
                'data' => Blog::select($id)
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getAllPosts() {
        try {
            return json_encode([
                'status' => 'success',
                'data' => Blog::selectAll()
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function createPost($data) {
        try {
            return json_encode([
                'status' => 'success',
                'message' => Blog::insert($data)
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deletePost($id) {
        try {
            return json_encode([
                'status' => 'success',
                'message' => Blog::delete($id)
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
