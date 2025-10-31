<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $categoryCount = Category::count();
        return view('dashboard', compact('userCount','categoryCount'));
    }
}

