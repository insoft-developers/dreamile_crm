<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Presentation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function consultant():BelongsTo
    {
        return $this->belongsTo(User::class, 'consultant_id', 'id');
    }

    public function createdBy():BelongsTo
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }

    public function branch():BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function leads():HasMany
    {
        return $this->hasMany(Customer::class, 'presentation_id', 'id')
            ->where('status', '!=', 'deal');
    }

    public function deals():HasMany
    {
        return $this->hasMany(Customer::class, 'presentation_id', 'id')
            ->where('status', 'deal');
    }
}
