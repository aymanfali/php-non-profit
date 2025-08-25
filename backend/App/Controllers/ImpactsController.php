<?php

namespace App\Controllers;

use App\Core\APIController;
use App\Models\Impacts;

class ImpactsController extends APIController
{
    protected $modelClass = Impacts::class;

    public function index()
    {
        try {
            $impact = $this->getModel();
            $impacts = $impact->all();

            $this->jsonResponse($impacts, 200);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Failed to fetch impacts.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        if (!$id) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Impact ID missing.'
            ], 400);
        }

        try {
            $impact = $this->getModel();
            $existing = $impact->find($id);

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
                    'message' => 'Impact not found.'
                ], 404);
            }
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Failed to fetch impact.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
