<?php
if (!function_exists('logged_in')) {
    function logged_in() {
        // Check if the 'user_id' session variable exists
        $session = \Config\Services::session();
        return $session->has('user_id');
    }
}