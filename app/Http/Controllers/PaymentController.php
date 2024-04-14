<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\Payment\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function pay()
    {
        $invoice = Invoice::find(1);

        $this->transaction->pay($invoice);
    }
}
