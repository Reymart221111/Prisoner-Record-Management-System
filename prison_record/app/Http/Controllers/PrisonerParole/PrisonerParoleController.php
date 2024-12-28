<?php

namespace App\Http\Controllers\PrisonerParole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrisonerParoleController extends Controller
{
    public function index()
    {
        return view('contents.superadmin.prisoner-parole.prisoner-parole-index');
    }
}
