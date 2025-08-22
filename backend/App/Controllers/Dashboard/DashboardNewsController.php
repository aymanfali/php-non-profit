<?php

namespace App\Controllers\Dashboard;

use App\Core\Controller;
use App\Models\News;

class DashboardNewsController extends Controller
{
    function index($id = null)
    {
        header('Content-Type: application/json');
        $news = new News();
        if ($id !== null) {
            $result = $news->find($id);
            echo json_encode($result);
            return;
        }
        if (isset($_GET['search']) && $_GET['search'] !== '') {
            $newss = $news->search($_GET['search']);
        } else {
            $newss = $news->all();
        }
        echo json_encode($newss);
    }

    function store()
    {
        header('Content-Type: application/json');
        $news = new News();
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
            $created = $news->create(
                $title,
                $image,
                $content,
            );
            echo json_encode(['success' => true, 'message' => 'news created successfully.', 'news' => $created]);
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
        $news = new News();
        if ($id) {
            $existing = $news->find($id);
            if ($existing) {
                $news->update($id, $title, $image, $content);
            }
            echo json_encode(['success' => true, 'message' => 'news updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'news ID missing.']);
        }
    }

    function delete($id)
    {
        header('Content-Type: application/json');
        if ($id) {
            $news = new News();
            $existing = $news->find($id);
            if ($existing) {
                $news->delete($id);
                echo json_encode(['success' => true, 'message' => 'news deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'news not found.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'news ID missing.']);
        }
    }
}
