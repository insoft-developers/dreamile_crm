<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id'=>$this->id,

            'customer_name'=>$this->customer_name,

            'phone'=>$this->phone,

            'status'=>$this->status,

            'assigned_to'=>$this->assigned_to,

            'unread_count'=>$this->unread_count,

            'last_message_at'=>$this->last_message_at,

            'customer'=>$this->customer,

            'latest_message'=>$this->latestMessage,

        ];
    }
}