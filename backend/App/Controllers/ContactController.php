<?php

namespace App\Controllers;

use App\Core\APIController;
use App\Models\Contact;

class ContactController extends APIController
{
    protected $modelClass = Contact::class;

    public function store()
    {
        $input = $this->getInput();

        $name = $input['name'] ?? null;
        $email = $input['email'] ?? null;
        $subject = $input['subject'] ?? null;
        $message = $input['message'] ?? null;

        if (!$name || !$email || !$subject || !$message) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Missing required fields.'
            ], 400);
        }

        try {
            $contact = $this->getModel();
            $created = $contact->create($name, $email, $subject, $message);

            $this->jsonResponse([
                'success' => true,
                'message' => 'Your message received successfully.',
                'contact' => $created
            ], 201);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Failed to store message.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
