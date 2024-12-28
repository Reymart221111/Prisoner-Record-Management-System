<?php

namespace App\Http\Controllers\PrisonerCrime;

use App\Http\Controllers\Controller;
use App\Models\Crime;
use App\Models\Prisoner;
use Illuminate\Http\Request;

class CrimePrisonerController extends Controller
{
    public function index()
    {
        return view('contents.superadmin.prisoner-crimes.prisoner-crimes-index');
    }

    public function prisonerCrimeIndex(Prisoner $prisoner)
    {
        $viewing = true;
        return view('contents.superadmin.prisoner-crimes.prisoner-crimes-index', compact('viewing', 'prisoner'));
    }

    public function showAddingPage(Prisoner $prisoner)
    {
        $adding = true;
        return view('contents.superadmin.prisoner-crimes.prisoner-crimes-index', compact('adding', 'prisoner'));
    }

    public function showEdittingPage($prisonerCrimeId)
    {
        $editting = true;
        return view('contents.superadmin.prisoner-crimes.prisoner-crimes-index', 
            compact('editting', 'prisonerCrimeId')
        );
    }
}
