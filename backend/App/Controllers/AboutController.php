<?php

namespace App\Controllers;

use App\Models\About;

class AboutController
{
    function view()
    {
        $about = new About();
        if (1) {
            $existing = $about->find(1);
            if ($existing) {
                // Corrected code: Access properties using array notation
                echo json_encode([
                    'id' => $existing['id'],
                    'our_history' => $existing['our_history'],
                    'our_history_image' => $existing['our_history_image'],
                    'our_values' => $existing['our_values'],
                    'our_values_image' => $existing['our_values_image']
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Data not found.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data ID missing.'
            ]);
        }
    }
}
