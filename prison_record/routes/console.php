<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Prisoner;
use App\Enums\PrisonerStatus;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Check and process prisoner releases daily
Schedule::call(function (): void {
    Prisoner::active() // Using the scopeActive method
        ->whereNotNull('release_date')
        ->whereDate('release_date', '<=', Carbon::now()->startOfDay())
        ->each(function ($prisoner) {
            $prisoner->status = PrisonerStatus::RELEASED;
            $prisoner->status_note = 'Automatically released due to completed sentence';
            $prisoner->save(); // This will trigger the observer
        });
})->everyFiveSeconds();
