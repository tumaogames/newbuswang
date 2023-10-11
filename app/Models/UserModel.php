<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // Table name and primary key for the 'users' table
    protected $table = 'users';
    protected $primaryKey = 'id';

    // Fields that are allowed to be updated in the database using the 'save()' method.
    protected $allowedFields = ['username', 'email', 'password', 'full_name', 'date_of_birth', 'created_at', 'updated_at'];

    // Validation rules for inserting or updating a user record.
    // Note: These rules are for creating new users and should not be used for the login process.
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[3]',
        'full_name' => 'required|max_length[100]',
        'date_of_birth' => 'required',
        'created_at' => 'permit_empty',
        'updated_at' => 'permit_empty',
    ];

    // Custom validation error messages.
    protected $validationMessages = [
        'username' => [
            'is_unique' => 'The {field} field must be unique.',
        ],
        'email' => [
            'is_unique' => 'The {field} field must be unique.',
        ],
    ];

    // Custom methods for user-related database operations.

    /**
     * Get a user record by their ID.
     *
     * @param int $userId The user ID.
     *
     * @return array|null The user record as an associative array or null if not found.
     */
    public function getUserById($userId)
    {
        return $this->find($userId);
    }
}