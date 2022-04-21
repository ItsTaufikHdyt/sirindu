<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function superAdminHome()
    {
        return view('admin.home');
    }

    public function adminHome()
    {
        return view('admin.home');
    }

    public function ibu()
    {

    }
}
