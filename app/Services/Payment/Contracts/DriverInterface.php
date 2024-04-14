<?php

namespace App\Services\Payment\Contracts;

use App\Models\Payment;

interface DriverInterface
{
    const TRANSACTION_FAILED = 'transaction.failed';
    const TRANSACTION_SUCCESS = 'transaction.success';

    public function pay(Payment $payment);
};
