<?php

namespace App\Services\Payment;

use App\Services\Payment\Drivers\Pasargad;
use Illuminate\Support\ServiceProvider;

class TransactionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $drivers = $this->getDriversClassName();

        foreach ($drivers as $driverName => $className) {
            $this->app->bind($driverName, function () use ($className) {
                return new $className();
            });
        };
    }

    private function getDriversClassName()
    {
        $drivers = glob(base_path('App/Services/Payment/Drivers/*.php'));

        foreach ($drivers as $driver) {
            $driverName = pathinfo($driver)['filename'];

            $result[strtolower($driverName)] = 'App\Services\Payment\Drivers\\' . ucfirst($driverName);
        };

        return $result;
    }
};
