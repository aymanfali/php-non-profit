<?php

namespace App\Controllers;

use App\Core\APIController;
use App\Models\About;

class AboutController extends APIController
{
    protected $modelClass = About::class;

    public function show($id = 1)
    {
        $about = $this->getModel();
        $existing = $about->find($id);

        if ($existing) {
            $this->jsonResponse([
                'id' => $existing['id'],
                'our_history' => $existing['our_history'],
                'our_history_image' => $existing['our_history_image'],
                'our_values' => $existing['our_values'],
                'our_values_image' => $existing['our_values_image']
            ], 200);
        } else {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Data not found.'
            ], 404);
        }
    }
}
