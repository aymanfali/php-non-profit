<?php

namespace App\Controllers\Dashboard;

use App\Core\Controller;
use App\Models\Contact;

class DashboardContactsController extends Controller
{
    function index($id = null)
    {
        header('Content-Type: application/json');
        $contact = new Contact();
        if ($id !== null) {
            $result = $contact->find($id);
            echo json_encode($result);
            return;
        }
        if (isset($_GET['search']) && $_GET['search'] !== '') {
            $contacts = $contact->search($_GET['search']);
        } else {
            $contacts = $contact->all();
        }
        echo json_encode($contacts);
    }

    function delete($id)
    {
        header('Content-Type: application/json');
        if ($id) {
            $contact = new Contact();
            $existing = $contact->find($id);
            if ($existing) {
                $contact->delete($id);
                echo json_encode(['success' => true, 'message' => 'contact deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'contact not found.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'contact ID missing.']);
        }
    }
}
