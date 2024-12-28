<?php

namespace App\Http\Controllers\PrisonerMedicalRecord;

use App\Http\Controllers\Controller;
use App\Models\Prisoner;
use App\Models\PrisonerMedicalRecord;
use Illuminate\Http\Request;

class PrisonerMedicalRecordController extends Controller
{
    public function index()
    {
        return view('contents.superadmin.prisoner-medical-records.prisoner-medical-records-index');
    }

    public function showPrisonerMedicalRecord(Prisoner $prisoner)
    {
        $viewingPrisonerRecord = true;
        return view('contents.superadmin.prisoner-medical-records.prisoner-medical-records-index', compact('viewingPrisonerRecord', 'prisoner'));
    }

    public function showAddingPage(Prisoner $prisoner)
    {
        $adding = true;
        return view('contents.superadmin.prisoner-medical-records.prisoner-medical-records-index', compact('adding', 'prisoner'));
    }

    public function showViewingMedicalRecord(PrisonerMedicalRecord $prisonerMedicalRecord)
    {
        $viewing = true;
        return view('contents.superadmin.prisoner-medical-records.prisoner-medical-records-index', compact('viewing', 'prisonerMedicalRecord'));
    }

    public function showEditingPage(PrisonerMedicalRecord $prisonerMedicalRecord)
    {
        $editing = true;
        return view('contents.superadmin.prisoner-medical-records.prisoner-medical-records-index', compact('editing', 'prisonerMedicalRecord'));
    }
}
