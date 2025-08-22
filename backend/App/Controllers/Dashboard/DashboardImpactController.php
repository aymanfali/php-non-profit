<?php

namespace App\Controllers\Dashboard;

use App\Core\Controller;
use App\Models\Impacts;

class DashboardImpactController extends Controller
{
    function index($id = null)
    {
        header('Content-Type: application/json');
        $impact = new Impacts();
        if ($id !== null) {
            $result = $impact->find($id);
            echo json_encode($result);
            return;
        }
        if (isset($_GET['search']) && $_GET['search'] !== '') {
            $impacts = $impact->search($_GET['search']);
        } else {
            $impacts = $impact->all();
        }
        echo json_encode($impacts);
    }

    function store()
    {
        header('Content-Type: application/json');
        $impact = new Impacts();
        $title = $_POST['title'] ?? '';
        $image = $_POST['image'] ?? '';
        $content = $_POST['content'] ?? '';
        if ($title === '' || $image === '' || $content === '') {
            $input = json_decode(file_get_contents('php://input'), true);
            $title = $input['title'] ?? $title;
            $image = $input['image'] ?? $image;
            $content = $input['content'] ?? $content;
        }
        if ($title && $image && $content) {
            $created = $impact->create(
                $title,
                $image,
                $content,
            );
            echo json_encode(['success' => true, 'message' => 'impact created successfully.', 'impact' => $created]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        }
    }

    function update($id)
    {
        header('Content-Type: application/json');
        $title = $_POST['title'] ?? '';
        $image = $_POST['image'] ?? '';
        $content = $_POST['content'] ?? '';
        if ($title === '' || $image === '' || $content === '') {
            $input = json_decode(file_get_contents('php://input'), true);
            $title = $input['title'] ?? $title;
            $image = $input['image'] ?? $image;
            $content = $input['content'] ?? $content;
        }
        $impact = new Impacts();
        if ($id) {
            $existing = $impact->find($id);
            if ($existing) {
                $impact->update($id, $title, $image, $content);
            }
            echo json_encode(['success' => true, 'message' => 'impact updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'impact ID missing.']);
        }
    }

    function delete($id)
    {
        header('Content-Type: application/json');
        if ($id) {
            $impact = new Impacts();
            $existing = $impact->find($id);
            if ($existing) {
                $impact->delete($id);
                echo json_encode(['success' => true, 'message' => 'impact deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'impact not found.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'impact ID missing.']);
        }
    }
}
