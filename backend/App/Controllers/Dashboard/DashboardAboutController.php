<?php

namespace App\Controllers\Dashboard;

use App\Core\APIController;
use App\Models\About;

class DashboardAboutController extends APIController
{
    protected $modelClass = About::class;

    public function index($id)
    {
        try {
            $about_us = $this->getModel();
            $result = $about_us->find($id);

            if ($result) {
                $this->jsonResponse($result);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'About Us record not found.'], 404);
            }
        } catch (\Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    function update($id)
    {
        $input = $this->getInput();

        $requiredFields = ['our_history', 'our_history_image', 'our_values', 'our_values_image'];
        foreach ($requiredFields as $field) {
            if (empty($input[$field])) {
                $this->jsonResponse(['success' => false, 'message' => "Field '$field' is required."], 400);
            }
        }

        $model = $this->getModel();
        $existing = $model->find($id);

        if (!$existing) {
            $this->jsonResponse(['success' => false, 'message' => 'About Us record not found.'], 404);
        }

        $model->update($id, $input['our_history'], $input['our_history_image'], $input['our_values'], $input['our_values_image']);
        $this->jsonResponse(['success' => true, 'message' => 'About Us data updated successfully.']);
    }
}
