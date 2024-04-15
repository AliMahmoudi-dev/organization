<?php

use App\Models\Invoice;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $transaction = resolve(App\Services\Payment\Transaction::class);
    $unpaidInvoices = Invoice::where('status', 1)->get();

    if ($unpaidInvoices->isNotEmpty()) {
        foreach ($unpaidInvoices as $invoice) {
            $transaction->pay($invoice);
        };
    };
})->daily();
