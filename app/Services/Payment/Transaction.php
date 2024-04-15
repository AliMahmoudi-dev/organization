<?php

namespace App\Services\Payment;

use App\Models\Invoice;
use App\Models\Payment;
use App\Services\Payment\Contracts\DriverInterface;
use Illuminate\Http\Request;

class Transaction
{
    private $setting;

    private $invoice;

    public function __construct()
    {
        $this->setting = config('payment');
    }

    public function pay(Invoice $invoice)
    {
        $this->invoice = $invoice;

        $payment = $this->createPayment();

        $response = $this->driverFactory()->pay($payment);

        if ($response['status'] == DriverInterface::TRANSACTION_FAILED)
            return false;

        $payment->markAsPaid($response['ref_id']);

        return true;
    }

    private function createPayment()
    {
        return Payment::create([
            'merchant_sheba' => $this->getMerchantShebaNumber(),
            'invoice_id' => $this->invoice->id,
            'bank' => $this->getDriverName(),
        ]);
    }

    private function getMerchantShebaNumber()
    {
        return $this->setting['drivers'][$this->getDriverName()]['merchantSheba'];
    }

    private function driverFactory()
    {
        return resolve($this->getDriverName());
    }

    private function getDriverName()
    {
        foreach ($this->setting['drivers'] as $name => $value) {
            if (preg_match($value['shebaPattern'], $this->invoice->sheba_number)) {
                return $name;
            };
        };
    }
}
