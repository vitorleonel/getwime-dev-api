<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

use App\Http\Resources\MessageResource;

class ListController extends Controller
{
    /**
     * @param int $chatId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(int $chatId, Request $request)
    {
        $messages = Message::where('chat_id', $chatId)->get();

        return response()->json([
            'messages' => MessageResource::collection($messages)
        ]);
    }
}
