<?php

namespace Tests;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Tenancy;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->purgeTenantDatabases();
        $this->artisan('migrate:fresh', ['--force' => true]);
    }

    protected function tearDown(): void
    {
        $this->purgeTenantDatabases();

        parent::tearDown();
    }

    protected function purgeTenantDatabases(): void
    {
        if ($this->app->bound(Tenancy::class)) {
            $tenancy = $this->app->make(Tenancy::class);

            if ($tenancy->initialized) {
                $tenancy->end();
            }
        }

        DB::disconnect('tenant');
        DB::purge('tenant');

        foreach (glob(database_path('tenant_*.sqlite')) ?: [] as $tenantDatabase) {
            @chmod($tenantDatabase, 0666);
            @unlink($tenantDatabase);
        }
    }

    /**
     * @param array<string, mixed> $attributes
     */
    protected function provisionTenant(string $id, string $domain, array $attributes = []): Tenant
    {
        /** @var Tenant $tenant */
        $tenant = Tenant::create([
            'id' => $id,
            ...$attributes,
        ]);

        $tenant->domains()->create([
            'domain' => $domain,
        ]);

        $this->artisan('tenants:migrate', [
            '--tenants' => [$tenant->getTenantKey()],
            '--force' => true,
        ])->assertExitCode(0);

        return $tenant->fresh(['domains']);
    }

    protected function tenantUrl(string $host, string $uri): string
    {
        return sprintf('http://%s%s', $host, $uri);
    }
}
