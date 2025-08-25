<?php

namespace App\Controllers\Dashboard;

use App\Core\APIController;
use App\Models\Impacts;

class DashboardImpactController extends APIController
{
    protected $modelClass = Impacts::class;

    function index($id = null)
    {
        $impact = $this->getModel();

        if ($id !== null) {
            $result = $impact->find($id);
            if ($result) {
                $this->jsonResponse($result, 200);
            }
            $this->jsonResponse(['success' => false, 'message' => 'Impact not found.'], 404);
        }
        if (isset($_GET['search']) && $_GET['search'] !== '') {
            $impacts = $impact->search($_GET['search']);
        } else {
            $impacts = $impact->all();
        }
        $this->jsonResponse($impacts, 200);
    }

    function store()
    {
        $impact = $this->getModel();
        $input = $this->getInput();

        if (empty($input['title'] ?? '') || empty($input['image'] ?? '') || empty($input['content'] ?? '')) {
            $this->jsonResponse(['success' => false, 'message' => 'Missing required fields.'], 400);  // Bad Request
        }

        $created = $impact->create($input['title'], $input['image'], $input['content']);
        $this->jsonResponse(['success' => true, 'message' => 'Impact created successfully.', 'impact' => $created], 201); // Created
    }

    function update($id)
    {
        $impact = $this->getModel();
        $input = $this->getInput();
        $existing = $impact->find($id);
        if (!$existing) {
            $this->jsonResponse(['success' => false, 'message' => 'impact not found.'], 404);
        }

        $impact->update(
            $id,
            $input['title'] ?? $existing['title'],
            $input['image'] ?? $existing['image'],
            $input['content'] ?? $existing['content']
        );

        $this->jsonResponse(['success' => true, 'message' => 'Impact updated successfully.'], 200); // OK
    }

    function delete($id)
    {
        $impact = $this->getModel();
        $existing = $impact->find($id);

        if (!$existing) {
            $this->jsonResponse(['success' => false, 'message' => 'impact not found.'], 404);
        }

        $impact->delete($id);
        $this->jsonResponse(['success' => true, 'message' => 'impact deleted successfully.'], 200); // OK
    }
}
