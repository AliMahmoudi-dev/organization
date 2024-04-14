<?php

namespace App\Services\Payment\Drivers;

use App\Models\Payment;
use App\Services\Payment\Contracts\DriverInterface;

class Pasargad implements DriverInterface
{
    public function pay(Payment $payment)
    {
        $response = $this->callApi($this->getPayload($payment));

        return $response['status'] !== 'OK'
            ? $this->transactionFailed()
            : $this->transactionSuccess($response['refCode']);
    }

    private function transactionFailed()
    {
        return [
            'status' => self::TRANSACTION_FAILED,
        ];
    }

    private function transactionSuccess($ref_id)
    {
        return [
            'status' => self::TRANSACTION_SUCCESS,
            'ref_id' => $ref_id,
        ];
    }

    private function getPayload($payment)
    {
        return [
            'destinationName' => $payment->invoice->user->name,
            'destinationNumber' => $payment->invoice->sheba_number,
            'merchantIban' => $payment->merchant_sheba,
            'amount' => $payment->invoice->amount,
            'description' => $payment->invoice->description,
            'payment_id' => $payment->id,
        ];
    }

    private function callApi($data, $status = true)
    {
        return $status ? [
            'status' => 'OK',
            'refCode' => '140109040622138',
            'amount' => $data['amount'],
        ] : [
            'status' => 'FAILED'
        ];
    }
};
