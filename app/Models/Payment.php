<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank',
        'status',
        'ref_id',
        'invoice_id',
        'merchant_sheba',
        'destination_sheba',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function markAsPaid($ref_id)
    {
        DB::transaction(function () use ($ref_id) {
            $this->invoice()->update(['status' => 2]);

            $this->update(['status' => true, 'ref_id' => $ref_id]);
        });
    }
}
