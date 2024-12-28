<?php

namespace App\Http\Controllers\DiseasePrisoner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiseasePrisonerController extends Controller
{
    public function index()
    {
        return view('contents.superadmin.prisoner-disease.index');
    }
}
