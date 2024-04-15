<?php

namespace App\Services\Payment;

use App\Models\Invoice;
use App\Models\Payment;
use App\Services\Payment\Contracts\DriverInterface;
use Exception;
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

        $this->ensureHasRequiredParameters($response);

        if ($response['status'] == DriverInterface::TRANSACTION_FAILED)
            return false;

        $payment->markAsPaid($response['ref_id']);

        return true;
    }

    public function ensureHasRequiredParameters($array)
    {
        if (!array_key_exists('status', $array) || !array_key_exists('ref_id', $array)) {
            throw new Exception('The response does not contain the required parameters [status, ref_id]');
        };
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
