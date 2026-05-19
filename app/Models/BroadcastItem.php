<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BroadcastItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function customer():BelongsTo
    {
        return $this->belongsTo(Customer::class, 'phone', 'phone_number');
    }
}
