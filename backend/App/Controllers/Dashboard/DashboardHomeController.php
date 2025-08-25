<?php

namespace App\Controllers\Dashboard;

use App\Core\APIController;
use App\Models\Contact;
use App\Models\Impacts;
use App\Models\News;
use App\Models\User;

class DashboardHomeController extends APIController
{
    function index()
    {
        $users = (new User())->countUsers();
        $news = (new News())->countNews();
        $impacts = (new Impacts())->countImpacts();
        $messages = (new Contact())->countMessages();

        $this->jsonResponse([
            'users' => $users,
            'news' => $news,
            'impacts' => $impacts,
            'messages' => $messages
        ], 200);
    }
}
