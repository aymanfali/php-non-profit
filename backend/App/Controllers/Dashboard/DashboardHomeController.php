<?php

namespace App\Controllers\Dashboard;

use App\Core\Controller;
use App\Models\Contact;
use App\Models\Impacts;
use App\Models\News;
use App\Models\User;

class DashboardHomeController extends Controller
{
    function index()
    {
        $usersCount = new User();
        $newsCount = new News();
        $impactsCount = new Impacts();
        $messagesCount = new Contact();

        $users = $usersCount->countUsers();
        $news = $newsCount->countNews();
        $impacts = $impactsCount->countImpacts();
        $messages = $messagesCount->countMessages();

        echo json_encode([
            'users' => $users,
            'news' => $news,
            'impacts' => $impacts,
            'messages' => $messages
        ]);
    }
}
