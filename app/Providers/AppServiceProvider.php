<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
        $supervisorAbilities = [
            'view-all-invoices',
            'confirm-invoices',
            'reject-invoices',
        ];

        Gate::before(function (User $user) {
            if ($user->isSupervisor()) {
                return true;
            };
        });

        Gate::define('access-invoice', function (User $user, Invoice $invoice) {
            return $user->invoices()->where('id', $invoice->id)->exists();
        });

        foreach ($supervisorAbilities as $ability) {
            Gate::define($ability, fn (User $user) => $user->isSupervisor());
        };
    }
}
