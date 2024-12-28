<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'employee') {
            return view('contents.employee.feedbacks.index');
        } elseif (Auth::user()->role === 'superadmin') {
            return view('contents.superadmin.feedbacks.index');
        }
    }

    public function view($id)
    {
        $viewing = true;
        $feedback = Feedback::findOrFail($id);
        if (Auth::user()->role === 'superadmin') {
            return view('contents.superadmin.feedbacks.index', compact('viewing', 'feedback'));
        }
    }
}
