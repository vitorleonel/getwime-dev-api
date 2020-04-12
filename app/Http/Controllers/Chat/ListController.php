<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Models\Chat;

/**
 * Class ListController
 * @package App\Http\Controllers\Chat
 */
class ListController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $chats = $user->chats()->get();

        return response()->json([
            'chats' => $chats
        ]);
    }
}
