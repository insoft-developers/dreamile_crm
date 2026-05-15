<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Broadcast extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function items():HasMany
    {
        return $this->hasMany(BroadcastItem::class, 'broadcast_id');
    }

    public function branch():BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
