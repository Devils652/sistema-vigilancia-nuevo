<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Camera;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
      
        $totalUsers = User::count();
        $totalCameras = Camera::count();
        $activeCameras = Camera::where('status', true)->count();
        return view('admin.dashboard', compact('totalUsers', 'totalCameras', 'activeCameras'));
    }
}