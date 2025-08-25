<?php

namespace App\Controllers\Dashboard;

use App\Core\APIController;
use App\Models\Contact;
use App\Models\Impacts;
use App\Models\News;
use App\Models\User;
use Exception;

class DashboardSettingsController extends APIController
{
    function destroyUsers()
    {
        $this->truncateModel(User::class, 'users');
    }

    function destroyNews()
    {
        $this->truncateModel(News::class, 'news');
    }

    function destroyImpacts()
    {
        $this->truncateModel(Impacts::class, 'impacts');
    }

    function destroyContacts()
    {
        $this->truncateModel(Contact::class, 'contacts');
    }

    private function truncateModel(string $modelClass, string $label): void
    {
        $model = new $modelClass();

        try {
            $model->truncate();
            $this->jsonResponse([
                'success' => true,
                'message' => "All {$label} deleted successfully."
            ], 200);
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => "Failed deleting {$label}.",
            ], 500);
        }
    }
}
