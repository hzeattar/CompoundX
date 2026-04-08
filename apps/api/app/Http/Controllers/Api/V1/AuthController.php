<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Models\User;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $identifier = $request->string('identifier')->toString();

        $user = User::query()
            ->where('email', $identifier)
            ->orWhere('mobile', $identifier)
            ->first();

        if (! $user || ! Hash::check($request->string('password')->toString(), $user->password) || ! $user->is_active) {
            return ApiResponse::error(
                request: $request,
                message: 'The provided credentials are invalid.',
                errors: ['identifier' => ['The provided credentials are invalid.']],
                status: Response::HTTP_UNAUTHORIZED,
            );
        }

        $token = Auth::guard('api')->login($user);

        return ApiResponse::success(
            request: $request,
            data: $this->tokenPayload($user, $token),
            message: 'Authentication succeeded.',
        );
    }

    public function refresh(Request $request)
    {
        $guard = Auth::guard('api');
        $token = $guard->refresh();
        /** @var User $user */
        $user = $guard->setToken($token)->user();

        return ApiResponse::success(
            request: $request,
            data: $this->tokenPayload($user, $token),
            message: 'Token refreshed successfully.',
        );
    }

    public function logout(Request $request)
    {
        Auth::guard('api')->logout();

        return ApiResponse::success(
            request: $request,
            data: null,
            message: 'Logged out successfully.',
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function tokenPayload(User $user, string $token): array
    {
        $guard = Auth::guard('api');

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $guard->factory()->getTTL() * 60,
            'refresh_expires_in' => (int) config('jwt.refresh_ttl') * 60,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'preferred_locale' => $user->preferred_locale,
            ],
        ];
    }
}
