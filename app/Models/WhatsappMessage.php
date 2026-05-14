<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WhatsappMessage extends Model
{
    use HasFactory;

    protected $fillable = ['conversation_id', 'phone', 'message', 'sender', 'message_id', 'status', 'attachment', 'type', 'userid', 'reply_message_id','mime_type','file_name'];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(WhatsappConversation::class, 'conversation_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function replyTo(): BelongsTo
    {
        return $this->belongsTo(WhatsappMessage::class, 'reply_message_id', 'message_id');
    }

    public function reactions():HasMany
    {
        return $this->hasMany(MessageReaction::class, 'message_id', 'id');
    }
}
