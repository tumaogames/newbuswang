<?php


namespace App\Controllers;
use App\Filters\AuthFilter;

class ViewController extends BaseController
{
    public function showLoginPage()
    {
        return view('login_view');
    }

    public function showRegistrationPage()
    {
        return view('registration_view');
    }

    public function showSuccessPage(){
        return view('success_page');
    }

    public function showDashboardPage(){
        return view('dashboard_page');
    }

    public function print(){
        return view('print');
    }
    public function print_back(){
        return view('print_back');
    }
}


