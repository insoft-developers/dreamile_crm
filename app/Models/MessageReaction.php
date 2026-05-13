<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MessageReaction extends Model
{
    use HasFactory;

    protected $fillable = ['message_id', 'user_id', 'emoji', 'customer_phone'];

    public function reactions(): HasMany
    {
        return $this->hasMany(MessageReaction::class);
    }
}
