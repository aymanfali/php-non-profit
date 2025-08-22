<?php

namespace App\Controllers\Dashboard;

use App\Core\Controller;
use App\Models\About;

class DashboardAboutController extends Controller
{
    public function index($id)
    {
        $about_us = new About();
        try {
            if ($id !== null) {
                $result = $about_us->find($id);
                echo json_encode($result);
            }
        } catch (\Exception $e) {
            echo json_encode(array("error" => $e->getMessage()));
        }
    }

    function update($id)
    {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);

        $our_history = $input['our_history'] ?? '';
        $our_history_image = $input['our_history_image'] ?? '';
        $our_values = $input['our_values'] ?? '';
        $our_values_image = $input['our_values_image'] ?? '';

        if (empty($our_history) || empty($our_history_image) || empty($our_values) || empty($our_values_image)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            return;
        }

        $about_us = new About();

        if ($id) {
            $existing = $about_us->find($id);
            if ($existing) {
                $about_us->update($id, $our_history, $our_history_image, $our_values, $our_values_image);
                echo json_encode(['success' => true, 'message' => 'About Us data updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'About Us record not found.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'About Us ID missing.']);
        }
    }
}
