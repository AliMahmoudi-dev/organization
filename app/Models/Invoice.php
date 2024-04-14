<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'path',
        'description',
        'sheba_number',
        'category_id',
        'user_id',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hasFile()
    {
        return !empty($this->path);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function alreadyPaid()
    {
        return $this->payments()->where('status', true)->exists();
    }

    public function isConfirmed()
    {
        return $this->status > 0;
    }
}
