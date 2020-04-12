<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

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
        $payload = $request->only(['name', 'description']);

        DB::beginTransaction();

        try {
            $user = $request->user();
            $chat = $user->chats()->create($payload);

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
