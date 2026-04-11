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
        
        $user = $model->where('username', $username)->first();
        
        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'id' => $user['id'],
                'name' => $user['name'],
                'username' => $user['username'],
                'role' => $user['role'],
                'logged_in' => true
            ]);
            return redirect()->to('/dashboard')->with('success', 'Welcome back, ' . $user['name'] . '!');
        }
        
        return redirect()->to('/login')->with('error', 'Invalid username or password');
    }
    
    public function register()
    {
        return view('auth/register');
    }
    
    public function doRegister()
    {
        $model = new UserModel();
        
        $existing = $model->where('username', $this->request->getPost('username'))->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Username already exists');
        }
        
        $model->insert([
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'name' => $this->request->getPost('name'),
            'role' => 'staff'
        ]);
        
        return redirect()->to('/login')->with('success', 'Registration successful! Please login.');
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Logged out successfully');
    }
}