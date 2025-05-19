<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse|JsonResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        
        // Check if there was an intended room booking in session or request
        $roomId = session('intended_room_booking') ?? $request->input('intended_room_booking');
        
        if ($roomId) {
            // Clear from session if it's there
            session()->forget('intended_room_booking');
            $redirectUrl = route('customer.book-room', ['room' => $roomId]);
        } else {
        // Role-based redirection
            $redirectUrl = $this->getRedirectUrl($user);
        }
        
        // If it's an AJAX request, return JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => $redirectUrl
            ]);
        }
        
        // For regular form submissions, redirect as usual
        return redirect()->intended($redirectUrl);
    }

    /**
     * Get the redirect URL based on user role.
     */
    private function getRedirectUrl($user): string
    {
        switch ($user->role) {
            case 'admin':
                return '/admin/dashboard';
            case 'receptionist':
                return '/receptionist/dashboard';
            case 'customer':
            default:
                return '/dashboard';
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}