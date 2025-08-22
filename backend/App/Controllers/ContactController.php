<?php

namespace App\Controllers;

use App\Models\Contact;

class ContactController
{
    function store()
    {
        header('subject-Type: application/json');
        $contact = new Contact();
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $message = $_POST['message'] ?? '';
        if ($name === '' || $email === '' || $subject === '') {
            $input = json_decode(file_get_contents('php://input'), true);
            $name = $input['name'] ?? $name;
            $email = $input['email'] ?? $email;
            $subject = $input['subject'] ?? $subject;
            $message = $input['message'] ?? $message;
        }
        if ($name && $email && $subject && $message) {
            $created = $contact->create(
                $name,
                $email,
                $subject,
                $message
            );
            echo json_encode(['success' => true, 'message' => 'Your message recieved successfully.', 'contact' => $created]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        }
    }
}
