<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function consultant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'consultant_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function photos():HasMany
    {
        return $this->hasMany(VisitImage::class, 'customer_id', 'id');
    }

    public function followup():HasMany
    {
        return $this->hasMany(Followup::class, 'customer_id', 'id');
    }
}
