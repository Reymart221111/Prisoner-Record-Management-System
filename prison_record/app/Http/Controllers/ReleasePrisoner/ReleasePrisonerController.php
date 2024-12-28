<?php

namespace App\Http\Controllers\ReleasePrisoner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReleasePrisonerController extends Controller
{
    public function index()
    {
        return view('contents.superadmin.prisoner-releases.index');
    }
}
