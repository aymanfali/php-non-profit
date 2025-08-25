<?php

namespace App\Controllers\Dashboard;

use App\Core\APIController;
use App\Models\News;

class DashboardNewsController extends APIController
{
    protected $modelClass = News::class;

    function index($id = null)
    {
        $news = $this->getModel();
        if ($id !== null) {
            $result = $news->find($id);
            if ($result) {
                $this->jsonResponse($result, 200);
            }
            $this->jsonResponse(['success' => false, 'message' => 'News not found.'], 404);
        }
        if (isset($_GET['search']) && $_GET['search'] !== '') {
            $newss = $news->search($_GET['search']);
        } else {
            $newss = $news->all();
        }
        $this->jsonResponse($newss, 200);
    }

    function store()
    {
        $news = $this->getModel();
        $input = $this->getInput();
        if (empty($input['title'] ?? '') || empty($input['image'] ?? '') || empty($input['content'] ?? '')) {
            $this->jsonResponse(['success' => false, 'message' => 'Missing required fields.'], 400);  // Bad Request
        }

        $created = $news->create($input['title'], $input['image'], $input['content']);
        $this->jsonResponse(['success' => true, 'message' => 'News created successfully.', 'news' => $created], 201); // Created
    }

    function update($id)
    {
        $news = $this->getModel();
        $input = $this->getInput();
        $existing = $news->find($id);
        if (!$existing) {
            $this->jsonResponse(['success' => false, 'message' => 'News not found.'], 404);
        }

        $news->update(
            $id,
            $input['title'] ?? $existing['title'],
            $input['image'] ?? $existing['image'],
            $input['content'] ?? $existing['content']
        );

        $this->jsonResponse(['success' => true, 'message' => 'News updated successfully.'], 200); // OK
    }

    function delete($id)
    {
        $news = $this->getModel();
        $existing = $news->find($id);

        if (!$existing) {
            $this->jsonResponse(['success' => false, 'message' => 'News not found.'], 404);
        }

        $news->delete($id);
        $this->jsonResponse(['success' => true, 'message' => 'News deleted successfully.'], 200); // OK
    }
}
