<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use App\Models\Chat;
use App\Http\Requests\Chat\StoreRequest;
use App\Http\Resources\ChatResource;

use Exception;

/**
 * Class StoreController
 * @package App\Http\Controllers\Chat
 */
class StoreController extends Controller
{
    /**
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request)
    {
        $userId = $request->user()->id;

        $payload = $request->only(['name', 'description']);
        $payload = array_merge($payload, ['user_id' => $userId]);

        DB::beginTransaction();

        try {
            $chat = Chat::create($payload);
            $chat->users()->syncWithoutDetaching($userId);

            DB::commit();

            return response()->json([
                'chat' => new ChatResource($chat)
            ], 201);
        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json(['message' => 'Não foi possível criar seu bate-papo. Tente novamente!'], 503);
        }
    }
}
