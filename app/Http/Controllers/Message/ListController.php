<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Chat;
use App\Http\Resources\MessageResource;

class ListController extends Controller
{
    /**
     * @param string $chatId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(string $chatId, Request $request)
    {
        $chat = Chat::select(['id'])->where('public_id', $chatId)->whereHas('users', function($query) use ($request) {
            return $query->where('user_id', $request->user()->id);
        })->first();

        if(!$chat) {
            return response()->json([
                'message' => 'Você não tem permissão para visualizar as mensagens desse bate-papo.'
            ], 404);
        }

        $chat->loadMissing('messages.user');

        $messages = MessageResource::collection($chat->messages);

        return response()->json([
            'messages' => $messages
        ]);
    }
}
