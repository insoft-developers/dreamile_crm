<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\MessageResource;
use App\Models\WhatsappConversation;
use App\Services\ConversationService;
use Illuminate\Http\Request;

class ConversationController extends Controller
{

    public function __construct(
        protected ConversationService $service
    ){}

    public function index(Request $request)
    {

        return ApiResponse::success(

            ConversationResource::collection(

                $this->service->list(
                    $request->user(),
                    $request
                )

            )

        );

    }

    public function show(WhatsappConversation $conversation)
    {

        return ApiResponse::success(

            new ConversationResource(

                $this->service->show($conversation)

            )

        );

    }

    public function messages(Request $request,WhatsappConversation $conversation)
    {

        return ApiResponse::success(

            MessageResource::collection(

                $this->service->messages(
                    $conversation,
                    $request->search
                )

            )

        );

    }

    public function take(Request $request,WhatsappConversation $conversation)
    {

        $this->service->take(
            $request->user(),
            $conversation
        );

        return ApiResponse::success(
            null,
            'Chat berhasil diambil'
        );

    }

    public function assign(Request $request,WhatsappConversation $conversation)
    {

        $request->validate([
            'user_id'=>'required|exists:users,id'
        ]);

        $this->service->assign(
            $conversation,
            $request->user_id
        );

        return ApiResponse::success(
            null,
            'Chat berhasil di-assign'
        );

    }

    public function resolve(WhatsappConversation $conversation)
    {

        $this->service->resolve($conversation);

        return ApiResponse::success(
            null,
            'Chat berhasil diselesaikan'
        );

    }

    public function reopen(WhatsappConversation $conversation)
    {

        $this->service->reopen($conversation);

        return ApiResponse::success(
            null,
            'Chat berhasil dibuka kembali'
        );

    }

}