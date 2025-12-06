<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Change_Password extends Controller
{
    public function index()
    {
    
        return redirect()->route('password.change.form');
    }
}
