<?php

namespace App\Controllers\Dashboard;

use App\Core\Controller;

class DashboardHomeController extends Controller
{
    function index()
    {
        echo json_encode('hi from dashboard');
    }
}
