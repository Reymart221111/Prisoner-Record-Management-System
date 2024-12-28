<?php

namespace App\Providers;
use App\Models\Prisoner;
use App\Models\PrisonerParole;
use App\Observers\DiseasePrisonerObserver;
use App\Observers\EscapePrisonerObserver;
use App\Observers\ParoleObserver;
use App\Observers\PrisonerObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // PrisonerParole::observe(ParoleObserver::class);
        // Prisoner::observe(PrisonerObserver::class);
        // Prisoner::observe(EscapePrisonerObserver::class);
        // Prisoner::observe(DiseasePrisonerObserver::class);
    }
}
