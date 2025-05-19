<?php

namespace App\Helpers;

class UserHelper
{
    public static function getDashboardRoute()
    {
        if (!auth()->check()) {
            return route('login');
        }

        $user = auth()->user();
        
        // Get role from the role column
        $role = $user->role;

        switch ($role) {
            case 'admin':
                return route('admin.dashboard');
            case 'receptionist':
                return route('receptionist.dashboard');
            case 'customer':
            default:
                return route('dashboard');
        }
    }
} 