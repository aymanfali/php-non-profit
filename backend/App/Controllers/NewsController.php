<?php

namespace App\Controllers;

use App\Core\APIController;
use App\Models\News;

class NewsController extends APIController
{
    protected $modelClass = News::class;

    public function index()
    {
        try {
            $newsModel = $this->getModel();
            $news = $newsModel->all();

            $this->jsonResponse($news, 200);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Failed to fetch news.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        if (!$id) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'News ID missing.'
            ], 400);
        }

        try {
            $newsModel = $this->getModel();
            $existing = $newsModel->find($id);

            if ($existing) {
                $this->jsonResponse([
                    'id' => $existing['id'],
                    'title' => $existing['title'],
                    'image' => $existing['image'],
                    'content' => $existing['content'],
                    'created_at' => $existing['created_at'],
                ], 200);
            } else {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'News not found.'
                ], 404);
            }
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Failed to fetch news.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
