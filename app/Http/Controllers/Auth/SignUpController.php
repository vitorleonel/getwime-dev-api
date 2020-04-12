<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\User;

/**
 * Class SignUpController
 * @package App\Http\Controllers\Auth
 */
class SignUpController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        $payload = [
            'name' => $this->getUuid($partial = true),
            'key_access' => $this->getUuid()
        ];

        DB::beginTransaction();

        try {
            $user = User::create($payload);
            $token = $this->generateToken($user);

            DB::commit();

            return response()->json([
                'token' => $token,
                'user' => $user
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->json(['message' => 'Não foi possível criar sua conta. Tente novamente!'], 503);
        }
    }

    /**
     * @param bool $partial
     * @return mixed|string
     */
    private function getUuid(bool $partial = false)
    {
        $response = (string) Str::uuid();

        if($partial) {
            $response = last(explode('-', $response));
        }

        return $response;
    }

    /**
     * @param User $user
     * @return string
     */
    private function generateToken(User $user)
    {
        $name = request()->device_name || 'Default';

        return $user->createToken($name)->plainTextToken;
    }
}
