<?php

namespace App\Controllers\Dashboard;

use App\Core\APIController;
use App\Models\Contact;

class DashboardContactsController extends APIController
{
    protected $modelClass = Contact::class;

    function index($id = null)
    {
        $contact = $this->getModel();

        if ($id !== null) {
            $result = $contact->find($id);
            if ($result) {
                $this->jsonResponse($result);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'Contact not found.'], 404);
            }
        }

        if (!empty($_GET['search'])) {
            $contacts = $contact->search($_GET['search']);
        } else {
            $contacts = $contact->all();
        }

        $this->jsonResponse($contacts, 200);
    }

    function delete($id)
    {
        if (!$id) {
            $this->jsonResponse(['success' => false, 'message' => 'Contact ID missing.'], 400);
        }

        $contact = $this->getModel();
        $existing = $contact->find($id);

        if (!$existing) {
            $this->jsonResponse(['success' => false, 'message' => 'Contact not found.'], 404);
        }

        $contact->delete($id);
        $this->jsonResponse(['success' => true, 'message' => 'Contact deleted successfully.'], 200);
    }
}
