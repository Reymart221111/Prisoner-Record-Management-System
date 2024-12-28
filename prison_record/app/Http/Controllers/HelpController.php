<?php

namespace App\Http\Controllers;

use App\Models\Help;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index()
    {
        return view('contents.superadmin.system-help.index');
    }

    public function showCreatePage()
    {
        $adding = true;

        return view('contents.superadmin.system-help.index', compact('adding'));
    }

    public function showEditPage(Help $help)
    {
        $editing = true;

        return view('contents.superadmin.system-help.index', compact('help', 'editing'));
    }

    public function showViewPage(Help $help)
    {
        $viewing = true;

        return view('contents.superadmin.system-help.index', compact('help', 'viewing'));
    }
}
