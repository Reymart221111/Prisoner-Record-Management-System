<?php

namespace App\Livewire;

use App\Models\Prisoner;
use App\Models\DiseasePrisoner;
use App\Models\EscapePrisoner;
use App\Models\TransfferedPrisoner;
use App\Models\PrisonerParole;
use App\Enums\SecurityLevel;
use App\Enums\PrisonerStatus;
use App\Models\PrisonerMedicalRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ViewDashboard extends Component
{
    public function getTotalPrisoners()
    {
        return Prisoner::where('status', PrisonerStatus::ACTIVE->value)->count();
    }

    public function getDeceasedInmates()
    {
        return DiseasePrisoner::count();
    }

    public function getIndefiniteSentence()
    {
        return Prisoner::whereNull('release_date')
            ->where('status', PrisonerStatus::ACTIVE)
            ->count();
    }

    public function getReleasesThisMonth()
    {
        return Prisoner::whereMonth('release_date', now()->month)
            ->whereYear('release_date', now()->year)
            ->count();
    }

    public function getHighRiskInmates()
    {
        return Prisoner::where('status', PrisonerStatus::ACTIVE)
            ->whereIn('security_level', [
                SecurityLevel::MAXIMUM->value,
                SecurityLevel::SUPERMAX->value
            ])->count();
    }

    public function getMedicalCases()
    {
        return Prisoner::whereHas('medicalRecords', function ($query) {
            $query->where('status', PrisonerStatus::ACTIVE->value);
        })->count();
    }

    public function getPrisonersWithParole()
    {
        return PrisonerParole::distinct('prisoner_id')->count();
    }

    public function getAdmissionsThisWeek()
    {
        return Prisoner::whereBetween('admission_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();
    }

    public function getTransfersThisMonth()
    {
        return TransfferedPrisoner::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    public function getEscapeAttemptsYTD()
    {
        return EscapePrisoner::whereYear('created_at', now()->year)->count();
    }

    public function getForeignNationals()
    {
        return Prisoner::where('status', PrisonerStatus::ACTIVE)
            ->whereRaw('LOWER(nationality) NOT LIKE ?', ['%filipino%'])
            ->count();
    }

    public function getMaximumSecurity()
    {
        return Prisoner::where('status', PrisonerStatus::ACTIVE)
            ->where('security_level', SecurityLevel::MAXIMUM)
            ->count();
    }

    public function getChartData()
    {
        return [
            'securityLevelDistribution' => $this->getSecurityLevelChartData(),
            'monthlyAdmissions' => $this->getMonthlyAdmissionsChartData(),
            'prisonerTrends' => $this->getPrisonerTrendsChartData(),
            'medicalCaseTypes' => $this->getMedicalCaseTypesChartData(),
        ];
    }

    private function getSecurityLevelChartData()
    {
        return [
            'Maximum' => Prisoner::where('status', PrisonerStatus::ACTIVE)
                ->where('security_level', SecurityLevel::MAXIMUM)->count(),
            'Medium' => Prisoner::where('status', PrisonerStatus::ACTIVE)
                ->where('security_level', SecurityLevel::MEDIUM)->count(),
            'Minimum' => Prisoner::where('status', PrisonerStatus::ACTIVE)
                ->where('security_level', SecurityLevel::MINIMUM)->count(),
            'Supermax' => Prisoner::where('status', PrisonerStatus::ACTIVE)
                ->where('security_level', SecurityLevel::SUPERMAX)->count(),
        ];
    }

    private function getMonthlyAdmissionsChartData()
    {
        $data = Prisoner::selectRaw('MONTH(admission_date) as month, COUNT(*) as count')
            ->whereYear('admission_date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = [];
        $counts = [];

        foreach ($data as $record) {
            $months[] = Carbon::create()->month($record->month)->format('M');
            $counts[] = $record->count;
        }

        return [
            'months' => $months,
            'counts' => $counts
        ];
    }

    private function getPrisonerTrendsChartData()
    {
        // Get last 12 months data
        $trends = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $trends->push([
                'month' => $date->format('M'),
                'admissions' => Prisoner::whereYear('admission_date', $date->year)
                    ->whereMonth('admission_date', $date->month)
                    ->count(),
                'releases' => Prisoner::whereYear('release_date', $date->year)
                    ->whereMonth('release_date', $date->month)
                    ->count(),
                'escapees' => Prisoner::whereHas('escapePrisoner', function($query) use ($date) {
                    $query->whereYear('escape_date', $date->year)
                        ->whereMonth('escape_date', $date->month);
                })->count(),
                'deceases' => Prisoner::whereHas('diseasePrisoner', function($query) use ($date) {
                    $query->whereYear('death_date', $date->year)
                        ->whereMonth('death_date', $date->month);
                })->count(),
                'transferees' => Prisoner::whereHas('transfferedPrisoner', function($query) use ($date) {
                    $query->whereYear('transfer_date', $date->year)
                        ->whereMonth('transfer_date', $date->month);
                })->count(),
            ]);
        }
    
        return $trends;
    }

    private function getMedicalCaseTypesChartData()
    {
        $medicalCases = PrisonerMedicalRecord::query()
            ->whereHas('prisoner', function ($query) {
                $query->where('status', PrisonerStatus::ACTIVE);
            })
            ->whereNotNull('medical_diagnosis')
            ->select('medical_diagnosis', DB::raw('COUNT(*) as count'))
            ->groupBy('medical_diagnosis')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        return [
            'conditions' => $medicalCases->pluck('medical_diagnosis'),
            'counts' => $medicalCases->pluck('count')
        ];
    }

    public function render()
    {
        return view('livewire.view-dashboard', [
            'totalPrisoners' => $this->getTotalPrisoners(),
            'deceasedInmates' => $this->getDeceasedInmates(),
            'indefiniteSentence' => $this->getIndefiniteSentence(),
            'releasesThisMonth' => $this->getReleasesThisMonth(),
            'highRiskInmates' => $this->getHighRiskInmates(),
            'medicalCases' => $this->getMedicalCases(),
            'prisonersWithParole' => $this->getPrisonersWithParole(),
            'admissionsThisWeek' => $this->getAdmissionsThisWeek(),
            'transfersThisMonth' => $this->getTransfersThisMonth(),
            'escapeAttemptsYTD' => $this->getEscapeAttemptsYTD(),
            'foreignNationals' => $this->getForeignNationals(),
            'maximumSecurity' => $this->getMaximumSecurity(),
            'chartData' => $this->getChartData(),
        ]);
    }
}
