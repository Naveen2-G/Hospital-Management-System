<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \Illuminate\Support\Facades\View::composer(
            ['components.appointment-modal', 'components.special-booking-modal'],
            function ($view) {
                $departments = \App\Models\Department::where('status', 'active')->get();
                $doctors = \App\Models\Doctor::where('status', 'active')->with('department')->get();
                $view->with(compact('departments', 'doctors'));
            }
        );
    }
}
