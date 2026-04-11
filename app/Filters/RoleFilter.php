<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }
        
        // Get required role from filter arguments
        $requiredRole = $arguments[0] ?? null;
        $userRole = session()->get('role');
        
        // If admin is required, check if user is admin
        if ($requiredRole === 'admin' && $userRole !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Access denied. This area is for administrators only.');
        }
        
        // If staff is required, check if user is staff or admin
        if ($requiredRole === 'staff' && $userRole !== 'staff' && $userRole !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Access denied.');
        }
        
        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}