<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
 public function index()
{
    \Log::info('Dashboard route hit');
    return view('contents.superadmin.dashboard');
}
}
