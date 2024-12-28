<?php

namespace App\Http\Controllers\Crimes;

use App\Http\Controllers\Controller;
use App\Models\Crime;
use Illuminate\Http\Request;

class CrimeController extends Controller
{
    public function index()
    {
        $crimes = Crime::paginate(5);
        return view('contents.superadmin.crimes.crimes-table', compact('crimes'));
    }

    public function search(Request $request)
    {
        $query = Crime::query();

        if (request()->filled('crime_name')) {
            $query->where('crime_name', 'like', '%' . $request->crime_name . '%');
        }

        $crimes = $query->paginate(5)->appends(request()->all());
        return view('contents.superadmin.crimes.crimes-table', compact('crimes'));
    }
    public function showAddingPage()
    {
        $adding = true;
        return view('contents.superadmin.crimes.crimes-table', compact('adding'));
    }

    public function showEditingPage(Crime $crime)
    {
        $editing = true;
        return view('contents.superadmin.crimes.crimes-table', compact('crime', 'editing'));
    }
}
