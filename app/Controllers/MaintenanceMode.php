<?php
// app/Controllers/MaintenanceMode.php

namespace App\Controllers;
error_reporting(E_ALL);
ini_set('display_errors', 1);
use CodeIgniter\Controller;
use Config\MaintenanceMode as MaintenanceModeConfig;

class MaintenanceMode extends BaseController
{
    public function index()
    {

        if (config('MaintenanceMode')->enabled) {
            return view('maintenance');
        }
    }
}


