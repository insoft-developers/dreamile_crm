<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactGroupItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function group():BelongsTo
    {
        return $this->belongsTo(ContactGroup::class, 'contact_group_id');
    }
    

    public function customer():BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
