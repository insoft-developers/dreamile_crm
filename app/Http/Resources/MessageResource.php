<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id'=>$this->id,

            'message'=>$this->message,

            'sender'=>$this->sender,

            'type'=>$this->type,

            'attachment'=>$this->attachment,

            'status'=>$this->status,

            'message_id'=>$this->message_id,

            'reply'=>$this->replyTo,

            'reactions'=>$this->reactions,

            'created_at'=>$this->created_at,

        ];
    }
}