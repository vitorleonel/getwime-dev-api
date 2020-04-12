<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;

use App\Http\Requests\Message\StoreRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;

/**
 * Class StoreController
 * @package App\Http\Controllers\Message
 */
class StoreController extends Controller
{
    /**
     * @param int $chatId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(int $chatId, StoreRequest $request)
    {
        $payload = [
            'chat_id' => $chatId,
            'user_id' => $request->user()->id,
            'description' => $request->description
        ];

        $message = Message::create($payload);

        return response()->json([
            'message' => new MessageResource($message)
        ], 201);
    }
}
