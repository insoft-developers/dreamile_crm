<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'phone',
        'message',
        'sender',
        'message_id',
        'status',
        'attachment',
        'type',
        'userid'
    ];

    public function conversation():BelongsTo
    {
        return $this->belongsTo(
            WhatsappConversation::class,
            'conversation_id'
        );
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'userid');
    }
}
