<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }
    
    public function login()
    {
        $model = new UserModel();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        // Find user by username
        $user = $model->where('username', $username)->first();
        
        // Debug - Uncomment if needed
        // echo "Username: " . $username . "<br>";
        // echo "Password entered: " . $password . "<br>";
        // if($user) {
        //     echo "User found: " . $user['username'] . "<br>";
        //     echo "Role: " . $user['role'] . "<br>";
        //     echo "Stored hash: " . $user['password'] . "<br>";
        //     echo "Password verify: " . (password_verify($password, $user['password']) ? "TRUE" : "FALSE");
        // }
        // exit;
        
        if ($user && password_verify($password, $user['password'])) {
            // Set session
            session()->set([
                'id' => $user['id'],
                'name' => $user['name'],
                'username' => $user['username'],
                'role' => $user['role'],
                'logged_in' => true
            ]);
            
            // Redirect based on role
            return redirect()->to('/dashboard')->with('success', 'Welcome ' . $user['name'] . '! You are logged in as ' . strtoupper($user['role']));
        }
        
        // If login fails
        return redirect()->to('/login')->with('error', 'Invalid username or password. Try: admin/admin123 or staff/staff123');
    }
    
    public function register()
    {
        return view('auth/register');
    }
    
    public function doRegister()
    {
        $model = new UserModel();
        
        // Check if username already exists
        $existing = $model->where('username', $this->request->getPost('username'))->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Username already exists. Please choose another.');
        }
        
        // Create new user (always staff by default)
        $model->insert([
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'name' => $this->request->getPost('name'),
            'role' => 'staff'
        ]);
        
        return redirect()->to('/login')->with('success', 'Registration successful! You can now login as staff member.');
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'You have been logged out successfully.');
    }
}

