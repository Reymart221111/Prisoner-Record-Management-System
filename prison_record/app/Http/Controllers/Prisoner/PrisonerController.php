<?php

namespace App\Http\Controllers\Prisoner;

use App\Enums\PrisonerStatus;
use App\Enums\SecurityLevel;
use App\Enums\Sex;
use App\Http\Controllers\Controller;
use App\Models\Prisoner;
use Illuminate\Http\Request;

class PrisonerController extends Controller
{
    public function index()
    {
        $prisoners = Prisoner::paginate(10);
        return view('contents.superadmin.prisoners.index', compact('prisoners'));
    }

    public function search(Request $request)
    {
        $query = Prisoner::query();

        // Prisoner ID
        if ($request->filled('prisoner_id')) {
            $query->where('prisoner_id', 'like', '%' . $request->prisoner_id . '%');
        }

        // Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Name
        if ($request->filled('first_name')) {
            $query->where('first_name', 'like', '%' . $request->first_name . '%');
        }
        if ($request->filled('last_name')) {
            $query->where('last_name', 'like', '%' . $request->last_name . '%');
        }

        // Nationality
        if ($request->filled('nationality')) {
            $query->where('nationality', 'like', '%' . $request->nationality . '%');
        }

        // Security Level
        if ($request->filled('security_level')) {
            $query->where('security_level', $request->security_level);
        }

        // Cell Location
        if ($request->filled('cell_block')) {
            $query->where('cell_block', 'like', '%' . $request->cell_block . '%');
        }
        if ($request->filled('cell_number')) {
            $query->where('cell_number', 'like', '%' . $request->cell_number . '%');
        }

        // Date of Birth Range
        if ($request->filled('date_of_birth_from')) {
            $query->where('date_of_birth', '>=', $request->date_of_birth_from);
        }
        if ($request->filled('date_of_birth_to')) {
            $query->where('date_of_birth', '<=', $request->date_of_birth_to);
        }

        // Admission Date Range
        if ($request->filled('admission_date_from')) {
            $query->where('admission_date', '>=', $request->admission_date_from);
        }
        if ($request->filled('admission_date_to')) {
            $query->where('admission_date', '<=', $request->admission_date_to);
        }

        // Release Date Range
        if ($request->filled('release_date_from')) {
            $query->where('release_date', '>=', $request->release_date_from);
        }
        if ($request->filled('release_date_to')) {
            $query->where('release_date', '<=', $request->release_date_to);
        }

        // Medical Conditions
        if ($request->filled('medical_conditions')) {
            $query->where('medical_conditions', 'like', '%' . $request->medical_conditions . '%');
        }

        $prisoners = $query->paginate(10);

        return view('contents.superadmin.prisoners.index', compact('prisoners'));
    }
    
    public function show(Prisoner $prisoner, Request $request)
    {
        $page = $request->query('page', 1);
        return view('contents.superadmin.prisoners.prisoner-index', compact('prisoner', 'page'));
    }
    public function showAddingPage()
    {
        return view('contents.superadmin.prisoners.create');
    }

    public function showEditingPage(Prisoner $prisoner)
    {
        return view('contents.superadmin.prisoners.update', compact('prisoner'));
    }
}
