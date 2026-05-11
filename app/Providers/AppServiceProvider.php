<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

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
        View::composer(
            ['components.appointment-modal', 'components.special-booking-modal'],
            function ($view) {
                // Avoid failing in early install / test environments where migrations haven't run yet.
                if (!Schema::hasTable('departments') || !Schema::hasTable('doctors')) {
                    $view->with(['departments' => collect(), 'doctors' => collect()]);
                    return;
                }

                $departments = \App\Models\Department::where('status', 'active')->get();
                $doctors = \App\Models\Doctor::where('status', 'active')->with('department')->get();
                $view->with(compact('departments', 'doctors'));
            }
        );
    }
}
