<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WhatsappConversation extends Model
{
    use HasFactory;

    protected $fillable = ['customer_name', 'phone', 'assigned_to', 'unread_count', 'last_message_at','status'];

    public function messages(): HasMany
    {
        return $this->hasMany(WhatsappMessage::class, 'conversation_id');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(WhatsappMessage::class, 'conversation_id')->latestOfMany();
    }

    public function customer():BelongsTo
    {
        return $this->belongsTo(Customer::class, 'phone', 'phone_number');
    }
}
