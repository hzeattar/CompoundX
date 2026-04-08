<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class BrandingBootstrapTest extends TestCase
{
    public function test_branding_bootstrap_returns_tenant_branding_for_host(): void
    {
        $tenant = $this->provisionTenant(
            id: 'tenant_alpha',
            domain: 'alpha.compoundx.test',
            attributes: [
                'name' => 'Alpha Residence',
                'company_name' => 'Alpha FM',
                'primary_color' => '#0f4c5c',
                'default_locale' => 'ar',
            ],
        );

        $response = $this->tenantRequest('GET', 'alpha.compoundx.test', '/api/v1/branding/bootstrap');

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.tenant.id', $tenant->id)
            ->assertJsonPath('data.tenant.name', 'Alpha Residence')
            ->assertJsonPath('data.tenant.company_name', 'Alpha FM')
            ->assertJsonPath('data.tenant.primary_color', '#0f4c5c')
            ->assertJsonPath('data.tenant.default_locale', 'ar');
    }

    public function test_branding_bootstrap_returns_not_found_for_unknown_host(): void
    {
        $response = $this->tenantRequest('GET', 'missing.compoundx.test', '/api/v1/branding/bootstrap');

        $response
            ->assertNotFound()
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'No tenant is mapped to the provided request host.');
    }

    private function tenantRequest(string $method, string $host, string $uri)
    {
        return $this->call($method, $this->tenantUrl($host, $uri), [], [], [], [
            'HTTP_ACCEPT' => 'application/json',
            'CONTENT_TYPE' => 'application/json',
        ]);
    }
}
