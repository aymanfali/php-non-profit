<?php

namespace App\Controllers;

class HomeController
{
    function index()
    {
        // require '../app/views/home/index.php';
        echo json_encode('hi from backend');
    }
}
