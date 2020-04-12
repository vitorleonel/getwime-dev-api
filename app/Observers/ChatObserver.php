<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Chat;

/**
 * Class ChatObserver
 * @package App\Observers
 */
class ChatObserver
{
    /**
     * Handle the chat "creating" event.
     *
     * @param  Chat  $chat
     * @return void
     */
    public function creating(Chat $chat)
    {
        $chat->public_id = (string) Str::uuid();
    }
}
