<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;

use App\Http\Requests\Message\StoreRequest;
use App\Http\Resources\MessageResource;

use App\Models\Message;
use App\Events\Message\StoreEvent;

/**
 * Class StoreController
 * @package App\Http\Controllers\Message
 */
class StoreController extends Controller
{
    /**
     * @param int $chatId
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(int $chatId, StoreRequest $request)
    {
        $payload = [
            'chat_id' => $chatId,
            'user_id' => $request->user()->id,
            'description' => $request->get('description')
        ];

        $message = Message::create($payload);

        $this->sendBroadCast(
            $request->get('public_id'),
            $message->toArray()
        );

        return response()->json([
            'message' => new MessageResource($message)
        ], 201);
    }

    /**
     * @param string $public_id
     * @param array $message
     */
    private function sendBroadcast(string $public_id, array $message)
    {
        try {
            broadcast(new StoreEvent($public_id, $message))->toOthers();
        } catch (\Exception $exception) {
            logger('Error on send broadcast message.');
        }
    }
}
