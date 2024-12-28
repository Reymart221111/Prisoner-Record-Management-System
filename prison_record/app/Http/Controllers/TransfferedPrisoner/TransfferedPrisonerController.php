<?php

namespace App\Http\Controllers\TransfferedPrisoner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransfferedPrisonerController extends Controller
{
    public function index()
    {
        return view('contents.superadmin.prisoner-transfferee.index');
    }
}
