<?php

namespace App\Http\Controllers;

use App\Services\AuditService;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function index(Request $request)
    {
        $query = $this->auditService->getAllActivities();

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('description', 'like', "%{$searchTerm}%")
                  ->orWhere('subject_type', 'like', "%{$searchTerm}%")
                  ->orWhere('event', 'like', "%{$searchTerm}%")
                  ->orWhere('causer_id', 'like', "%{$searchTerm}%");
            });
        }

        // Date range filtering
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        $activities = $query->paginate(30)->withQueryString();

        return view('contents.superadmin.audit-trail.index', compact('activities'));
    }

    public function show($modelType, $id)
    {
        $modelClass = "App\\Models\\$modelType";
        $model = $modelClass::findOrFail($id);
        $activities = $model->getAuditLogs()->paginate(30);
        
        return view('audit.show', compact('activities', 'model'));
    }
}