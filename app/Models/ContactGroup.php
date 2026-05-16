<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactGroup extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function branch():BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function items():HasMany
    {
        return $this->hasMany(ContactGroupItem::class, 'contact_group_id');
    }
}
