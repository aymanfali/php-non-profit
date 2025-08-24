<?php

namespace App\Controllers;

use App\Models\News;

class NewsController
{
    function index()
    {
        header('Content-Type: application/json');
        $new = new News();

        $news = $new->all();

        echo json_encode($news);
    }

    function view($id)
    {
        $new = new News();
        if ($id) {
            $existing = $new->find($id);
            if ($existing) {
                echo json_encode([
                    'id' => $existing['id'],
                    'title' => $existing['title'],
                    'image' => $existing['image'],
                    'content' => $existing['content'],
                    'created_at' => $existing['created_at'],
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'News not found.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'News ID missing.'
            ]);
        }
    }
}
