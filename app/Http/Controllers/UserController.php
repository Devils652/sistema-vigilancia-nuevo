<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('users.dashboard', [
            'user' => Auth::user()
        ]);
    }
}