<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = Room::where('status', 'Available')
            ->orderBy('type')
            ->get()
            ->groupBy('type');

        $services = Service::where('is_available', true)
            ->orderBy('category')
            ->get()
            ->groupBy('category');

        return view('home', compact('rooms', 'services'));
    }
}
