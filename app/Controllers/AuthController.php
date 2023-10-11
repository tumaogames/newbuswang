<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
error_reporting(E_ALL);
ini_set('display_errors', 1);

class AuthController extends Controller
{
    private $validation;
    public function __construct()
    {
        // Load the CodeIgniter validation library
        $this->validation = \Config\Services::validation();
    }

    public function login()
    {
        // Set the validation rules for the login form
        $rules = [
            'username' => 'required|min_length[5]|max_length[50]|alpha_dash',
            'password' => 'required|min_length[8]'
            // Add more rules as needed
        ];
        
        $this->validation->setRules($rules);
        // Handle the form submission
        if ($this->request->getMethod() === 'post') {
            // Run the validation
            if ($this->validation->withRequest($this->request)->run()) {
                // Validation passed, continue with login process
                // Example: Get the username and password
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');
                 // Load the database and the model (assuming you have created a UserModel)
                 $db = service('db');
                 $userModel = new \App\Models\UserModel();
 
                 // Find the user by username in the database
                 $user = $userModel->where('username', $username)->first();
                 // Check if the user exists and the password is correct
                 if ($user && password_verify($password, $user['password'])) {
                    // Successful login, set a session variable to indicate the user is logged in
                    session()->set('user_id', $user['id']);
                    session()->set('username', $user['username']);
                    session()->set('role', $user['role']);
                    // Retrieve user information from the session
                    $data['username'] = session()->get('username');
                    $data['role'] = session()->get('role');
                    // Redirect to a dashboard or home page after login
                    return view('/dashboard_page', $data);
                 } else {
                    // Invalid credentials, show an error message
                    $this->validation->setError('password', 'Invalid username or password.');
                 }
            } 
        }
        // If it's not a POST request or validation failed, show the login form
        // Validation failed, store the validation object in the session
        session()->setFlashdata('errors', $this->validation->getErrors());
        return view('login_view');
    }

    public function register()
    {
        $validationRules = [
            'username' => 'required|min_length[4]|max_length[20]|is_unique[users.username]|alpha_dash',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]|regex_match[/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%^&*()_+]{8,}$/]',
            'confirm_password' => 'required|matches[password]',
            'full_name' => 'required|alpha_space',
            'date_of_birth' => 'required|valid_date',
        ];

        $validationMessages = [
            'username' => [
                'is_unique' => 'Username is already taken',
            ],
            'email' => [
                'is_unique' => 'Email is already taken'
            ],
            'password' => [
                'regex_match' => 'The password must contain at least one letter, one number, and one special character.'
            ]
        ];

        $formData = $this->request->getPost();

        if ($this->request->getMethod() === 'post') {
            $this->validation->setRules($validationRules, $validationMessages);

            if ($this->validation->withRequest($this->request)->run()) {
                // Validation passed, proceed with registration logic

                // Dependency injection
                $userModel = new \App\Models\UserModel();
                $db = \Config\Database::connect();

                // Hash the password before storing it
                $hashedPassword = password_hash($formData['password'], PASSWORD_DEFAULT);

                try {
                    $db->transStart(); // Start transaction

                    // Prepare user data
                    $userData = [
                        'username' => $formData['username'],
                        'email' => $formData['email'],
                        'password' => $hashedPassword,
                        'full_name' => $formData['full_name'],
                        'date_of_birth' => $formData['date_of_birth'],
                    ];

                    // Insert user data into the database
                    $userModel->insert($userData);

                    $db->transCommit(); // Commit transaction

                    // Set flash message and redirect
                    session()->setFlashdata('success_message', 'Registration successful!');
                    return redirect()->to('success_page');
                } catch (\Exception $e) {
                    $db->transRollback(); // Rollback transaction on error
                    log_message('error', 'User registration error: ' . $e->getMessage());
                    return redirect()->back()->withInput()->with('error', 'Registration failed. Please try again later.');
                }
            } else {
                // If validation fails, store the errors in the session flashdata
                session()->setFlashdata('errors', $this->validation->getErrors());
                return view('registration_view', $formData);
            }
        }
    }

    public function logout()
    {
        $session = \Config\Services::session();
        $session->destroy();

        // Redirect the user to the login page or another appropriate page.
        return redirect()->to('/admin_login');
    }
}

