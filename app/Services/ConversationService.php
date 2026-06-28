<?php

namespace App\Services;

use App\Models\User;
use App\Models\WhatsappConversation;
use App\Models\WhatsappMessage;

class ConversationService
{

    public function list(User $user,$request)
    {

        return WhatsappConversation::query()

            ->when($request->search,function($q) use($request){

                $q->where(function($qq) use($request){

                    $qq->where('customer_name','like','%'.$request->search.'%')
                        ->orWhere('phone','like','%'.$request->search.'%');

                });

            })

            ->when($request->filter=="mychat",function($q) use($user){

                $q->where('assigned_to',$user->id);

            })

            ->when($request->filter=="assigned",function($q){

                $q->whereNotNull('assigned_to')
                    ->where('status','open');

            })

            ->when($request->filter=="unassigned",function($q){

                $q->whereNull('assigned_to');

            })

            ->when($request->filter=="resolved",function($q){

                $q->where('status','resolved');

            })

            ->with([
                'customer',
                'latestMessage'
            ])

            ->latest('last_message_at')

            ->paginate(20);

    }

    public function show(WhatsappConversation $conversation)
    {

        $conversation->update([
            'unread_count'=>0
        ]);

        return $conversation->load([
            'customer',
            'latestMessage'
        ]);

    }

    public function messages(WhatsappConversation $conversation,$search=null)
    {

        return WhatsappMessage::with([
            'replyTo',
            'reactions'
        ])

        ->where('conversation_id',$conversation->id)

        ->when($search,function($q) use($search){

            $q->where('message','like','%'.$search.'%');

        })

        ->latest()

        ->paginate(50);

    }

    public function take(User $user,WhatsappConversation $conversation)
    {

        $conversation->update([

            'assigned_to'=>$user->id,

            'status'=>'open'

        ]);

        return $conversation;

    }

    public function assign(WhatsappConversation $conversation,$userId)
    {

        $conversation->update([

            'assigned_to'=>$userId,

            'status'=>'open',

            'assign_at'=>now()

        ]);

        return $conversation;

    }

    public function resolve(WhatsappConversation $conversation)
    {

        $conversation->update([

            'status'=>'resolved'

        ]);

        return true;

    }

    public function reopen(WhatsappConversation $conversation)
    {

        $conversation->update([

            'status'=>'open'

        ]);

        return true;

    }

}