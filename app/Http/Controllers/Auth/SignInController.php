<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignInRequest;

use App\Models\User;

use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class SignInController
 * @package App\Http\Controllers\Auth
 */
class SignInController extends Controller
{

    /**
     * @param SignInRequest $request
     * @return JsonResponse
     */
    public function __invoke(SignInRequest $request)
    {
        try {
            $user = User::where('key_access', $request->key_access)->first();

            if(!$user) {
                throw new Exception('Chave de acesso inválida.', 404);
            }

            $user->tokens()->delete();
            $token = $this->generateToken($user);

            return response()->json([
                'token' => $token,
                'user' => $user
            ]);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
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
