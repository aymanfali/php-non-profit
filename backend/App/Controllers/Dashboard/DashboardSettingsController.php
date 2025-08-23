<?php

namespace App\Controllers\Dashboard;

use App\Core\Controller;
use App\Models\Contact;
use App\Models\Impacts;
use App\Models\News;
use App\Models\User;
use Exception;

class DashboardSettingsController extends Controller
{
    function destroyUsers()
    {
        header('Content-Type: application/json');

        $users = new User();
        try {
            $users->truncate();
            echo json_encode(['success' => true, 'message' => 'All users deleted successfully.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Failed deleting users.']);
        }
    }

    function destroyNews()
    {
        header('Content-Type: application/json');

        $news = new News();
        try {
            $news->truncate();
            echo json_encode(['success' => true, 'message' => 'All news deleted successfully.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Failed deleting news.']);
        }
    }

    function destroyImpacts()
    {
        header('Content-Type: application/json');

        $impacts = new Impacts();

        try {
            $impacts->truncate();
            echo json_encode(['success' => true, 'message' => 'All Impacts deleted successfully.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Failed deleting impacts.']);
        }
    }

    function destroyContacts()
    {
        header('Content-Type: application/json');

        $messages = new Contact();

        try {
            $messages->truncate();
            echo json_encode(['success' => true, 'message' => 'All Contacts deleted successfully.']);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Failed Deleting Contacts']);
        }
    }
}
