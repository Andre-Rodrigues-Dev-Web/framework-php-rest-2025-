<?php
namespace App\Services;

use App\Models\VideoAulas;

class VideoAulasService
{
    public function get($id) {
        try {
            $videoAula = VideoAulas::select($id);
            return [
                'status' => 'success',
                'data' => [$videoAula]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    public function getAll() {
        try {
            $videoAulas = VideoAulas::selectAll();
            return [
                'status' => 'success',
                'data' => $videoAulas // Retorna a lista como array
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    public function post($data) {
        try {
            return [
                'status' => 'success',
                'message' => VideoAulas::insert($data)
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    public function delete($id) {
        try {
            return [
                'status' => 'success',
                'message' => VideoAulas::delete($id)
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
