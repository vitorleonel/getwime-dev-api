<?php

namespace App\Http\Middleware\Message;

use Closure;
use App\Models\Chat;

class CanManipulate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $publicId = $request->route('id');

        $chat = Chat::select(['id'])
            ->where('public_id', $publicId)
            ->whereHas('users', function($query) use ($request) {
                return $query->where('user_id', $request->user()->id);
            })
            ->first();

        if(!$chat) {
            return response()->json([
                'message' => 'Você não tem permissão para visualizar as mensagens desse bate-papo.'
            ], 404);
        }

        $request->route()->setParameter('id', $chat->id);
        $request->attributes->add(['public_id' => $publicId]);

        return $next($request);
    }
}
