<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User;
use App\Models\Employee;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Booking;
use App\Models\Activity;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get statistics for dashboard
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $maintenanceRooms = Room::whereIn('status', ['maintenance', 'cleaning'])->count();
        $reservedRooms = Room::where('status', 'reserved')->count();

        $currentBookings = Booking::whereDate('check_in_date', '<=', now())
            ->whereDate('check_out_date', '>=', now())
            ->where('status', 'confirmed')
            ->count();

        $totalRevenue = Transaction::where('payment_method', 'cash')
            ->whereMonth('created_at', now()->month)
            ->sum('amount');

        $recentBookings = Booking::with(['room', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($booking) {
                return (object) [
                    'guest_name' => $booking->user->name ?? 'Guest',
                    'room_number' => $booking->room->room_number ?? 'N/A',
                    'check_in_date' => $booking->check_in_date,
                    'status' => $booking->status,
                    'total_amount' => $booking->total_amount
                ];
            });

        $recentActivities = Activity::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('Dashboards.Admin.dashboard', compact(
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'maintenanceRooms',
            'reservedRooms',
            'currentBookings',
            'totalRevenue',
            'recentBookings',
            'recentActivities'
        ));
    }

    public function rooms()
    {
        $rooms = Room::with('category')->get();
        $categories = Category::all();
        return view('Dashboards.Admin.rooms', compact('rooms', 'categories'));
    }

    public function employees()
    {
        $employees = User::where('role', 'receptionist')
            ->orWhere('role', 'admin')
            ->orderBy('name')
            ->get()
            ->map(function ($user) {
                return (object) [
                    'id' => $user->id,
                    'employee_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? 'Not provided',
                    'role' => $user->role,
                    'address' => $user->address ?? 'Not provided',
                    'joined_date' => $user->created_at,
                    'status' => $user->status ?? 'active'
                ];
            });
        return view('Dashboards.Admin.employees', compact('employees'));
    }

    public function transactions()
    {
        $transactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->map(function ($transaction) {
                return (object) [
                    'id' => $transaction->id,
                    'invoice_number' => $transaction->invoice_number,
                    'guest_name' => $transaction->guest_name ?? 'N/A',
                    'room_number' => $transaction->room_number ?? 'N/A',
                    'payment_method' => $transaction->payment_method,
                    'amount' => $transaction->amount,
                    'receptionist_id' => $transaction->user_id,
                    'receptionist_name' => $transaction->user->name ?? 'System',
                    'created_at' => $transaction->created_at,
                    'description' => $transaction->description,
                    'reference_number' => $transaction->reference_number
                ];
            });

        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::where('payment_method', 'cash')->sum('amount');
        $totalRefunds = Transaction::where('payment_method', 'credit')->sum('amount');
        $averageTransaction = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        $receptionists = User::where('role', 'receptionist')->get();

        return view('Dashboards.Admin.transactions', compact(
            'transactions',
            'totalTransactions',
            'totalRevenue',
            'totalRefunds',
            'averageTransaction',
            'receptionists'
        ));
    }

    public function users()
    {
        $users = User::orderBy('name')->paginate(10);
        return view('Dashboards.Admin.users', compact('users'));
    }

    public function receptionist()
    {
        return view('Dashboards.Admin.receptionist');
    }

    public function services()
    {
        return view('Dashboards.Admin.services');
    }

    // Room management methods
    public function storeRoom(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|unique:rooms',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'capacity' => 'required|integer',
            'status' => 'required|in:available,occupied,maintenance',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('room_images', 'public');

        Room::create([
            'room_number' => $validated['room_number'],
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'capacity' => $validated['capacity'],
            'status' => $validated['status'],
            'description' => $validated['description'],
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Room added successfully!');
    }

    public function updateRoom(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'room_number' => 'required|string|unique:rooms,room_number,' . $request->room_id,
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'capacity' => 'required|integer',
            'status' => 'required|in:available,occupied,maintenance',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $room = Room::findOrFail($request->room_id);

        $room->room_number = $validated['room_number'];
        $room->category_id = $validated['category_id'];
        $room->price = $validated['price'];
        $room->capacity = $validated['capacity'];
        $room->status = $validated['status'];
        $room->description = $validated['description'];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('room_images', 'public');
            $room->image = $imagePath;
        }

        $room->save();

        return redirect()->back()->with('success', 'Room updated successfully!');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name',
            'description' => 'required|string',
        ]);

        Category::create($validated);

        return redirect()->back()->with('success', 'Category added successfully!');
    }

    // Employee management methods
    public function storeEmployee(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string',
            'role' => 'required|string|in:admin,receptionist,manager',
            'address' => 'required|string',
            'password' => 'required|string|min:5',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'address' => $validated['address'],
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Employee added successfully!');
    }

    public function updateEmployee(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'phone' => 'required|string',
            'role' => 'required|string|in:admin,receptionist,manager',
            'address' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $user = User::findOrFail($request->id);
        $user->update($validated);

        return redirect()->back()->with('success', 'Employee updated successfully!');
    }

    public function activateEmployee(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->status = 'active';
        $user->save();

        return redirect()->back()->with('success', 'Employee activated successfully!');
    }

    public function deactivateEmployee(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->status = 'inactive';
        $user->save();

        return redirect()->back()->with('success', 'Employee deactivated successfully!');
    }

    // Transaction methods
    public function printTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('Dashboards.Admin.transaction-print', compact('transaction'));
    }

    public function exportTransactions(Request $request, $type)
    {
        // This would contain logic for exporting transactions to CSV or PDF
        // For now we'll return a redirect with a message
        return redirect()->back()->with('info', "Export functionality for {$type} will be implemented soon.");
    }

    // User management methods
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:5',
            'role' => 'required|in:admin,receptionist,customer',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->back()->with('success', 'User added successfully!');
    }

    public function updateUser(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'role' => 'required|in:admin,receptionist,customer',
        ]);

        $user = User::findOrFail($request->id);
        $user->update($validated);

        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function resetUserPassword(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:users,id',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($request->id);
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->back()->with('success', 'Password reset successfully!');
    }

    public function activateUser(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->status = 'active';
        $user->save();

        return redirect()->back()->with('success', 'User activated successfully!');
    }

    public function deactivateUser(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->status = 'inactive';
        $user->save();

        return redirect()->back()->with('success', 'User deactivated successfully!');
    }
}