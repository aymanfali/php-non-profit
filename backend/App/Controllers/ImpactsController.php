<?php

namespace App\Controllers;

use App\Models\Impacts;

class ImpactsController
{
    function index()
    {
        header('Content-Type: application/json');
        $impact = new Impacts();

        $impacts = $impact->all();

        echo json_encode($impacts);
    }

    function view($id)
    {
        $impact = new Impacts();
        if ($id) {
            $existing = $impact->find($id);
            if ($existing) {
                echo json_encode([
                    'id' => $existing->id,
                    'title' => $existing->title,
                    'image' => $existing->image,
                    'content' => $existing->content
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Impact not found.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Impact ID missing.'
            ]);
        }
    }
}
