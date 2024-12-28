<?php

namespace App\Providers;

use App\Models\Feedback;
use App\Models\Prisoner;
use App\Models\PrisonerParole;
use App\Models\User;
use App\Observers\DiseasePrisonerObserver;
use App\Observers\EscapePrisonerObserver;
use App\Observers\ParoleObserver;
use App\Observers\PrisonerObserver;
use App\Observers\ReleasePrisonerObserver;
use App\Observers\TransfferedPrisonerObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);


        Password::defaults(function () {
            return Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised();
        });

        PrisonerParole::observe(ParoleObserver::class);
        Prisoner::observe(PrisonerObserver::class);
        Prisoner::observe(EscapePrisonerObserver::class);
        Prisoner::observe(DiseasePrisonerObserver::class);
        Prisoner::observe(TransfferedPrisonerObserver::class);
        Prisoner::observe(ReleasePrisonerObserver::class);
        User::observe(UserObserver::class);
       

    }
}
