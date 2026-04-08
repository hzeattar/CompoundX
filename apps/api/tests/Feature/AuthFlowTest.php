<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    public function test_login_and_refresh_return_standard_envelope(): void
    {
        $tenant = $this->provisionTenant(
            'tenant_alpha',
            'alpha.compoundx.test',
            [
                'name' => 'Alpha Residence',
                'default_locale' => 'en',
            ],
        );

        $tenant->run(function (): void {
            User::factory()->create([
                'email' => 'resident@example.com',
                'mobile' => '9647000000000',
                'password' => 'password',
            ]);
        });

        $loginResponse = $this->tenantJson(
            method: 'POST',
            host: 'alpha.compoundx.test',
            uri: '/api/v1/auth/login',
            payload: [
                'identifier' => 'resident@example.com',
                'password' => 'password',
            ],
        );

        $loginResponse
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.user.email', 'resident@example.com');

        $accessToken = $loginResponse->json('data.access_token');

        $this->tenantJson(
            method: 'POST',
            host: 'alpha.compoundx.test',
            uri: '/api/v1/auth/refresh',
            payload: [],
            token: $accessToken,
        )
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'data' => ['access_token', 'token_type', 'expires_in', 'refresh_expires_in', 'user'],
                'message',
                'errors',
                'meta',
            ]);
    }

    public function test_login_rejects_invalid_credentials(): void
    {
        $tenant = $this->provisionTenant(
            'tenant_alpha',
            'alpha.compoundx.test',
            [
                'name' => 'Alpha Residence',
                'default_locale' => 'en',
            ],
        );

        $tenant->run(function (): void {
            User::factory()->create([
                'email' => 'resident@example.com',
                'password' => 'password',
            ]);
        });

        $this->tenantJson(
            method: 'POST',
            host: 'alpha.compoundx.test',
            uri: '/api/v1/auth/login',
            payload: [
                'identifier' => 'resident@example.com',
                'password' => 'wrong-password',
            ],
        )
            ->assertUnauthorized()
            ->assertJsonPath('success', false);
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function tenantJson(string $method, string $host, string $uri, array $payload, ?string $token = null)
    {
        $server = [
            'HTTP_ACCEPT' => 'application/json',
            'CONTENT_TYPE' => 'application/json',
        ];

        if ($token !== null) {
            $server['HTTP_AUTHORIZATION'] = 'Bearer ' . $token;
        }

        return $this->call(
            $method,
            $this->tenantUrl($host, $uri),
            [],
            [],
            [],
            $server,
            json_encode($payload, JSON_THROW_ON_ERROR),
        );
    }
}
