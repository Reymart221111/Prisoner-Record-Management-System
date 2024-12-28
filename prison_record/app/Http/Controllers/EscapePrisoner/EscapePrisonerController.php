<?php

namespace App\Http\Controllers\EscapePrisoner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EscapePrisonerController extends Controller
{
    public function index()
    {
        return view('contents.superadmin.prisoner-escapee.index');
    }
}
