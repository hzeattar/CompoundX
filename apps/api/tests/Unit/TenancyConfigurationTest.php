<?php

declare(strict_types=1);

namespace Tests\Unit;

use Stancl\Tenancy\TenantDatabaseManagers\PostgreSQLSchemaManager;
use Tests\TestCase;

class TenancyConfigurationTest extends TestCase
{
    public function test_pgsql_manager_uses_schema_isolation(): void
    {
        $this->assertSame(PostgreSQLSchemaManager::class, config('tenancy.database.managers.pgsql'));
        $this->assertSame('tenant_', config('tenancy.database.prefix'));
    }
}
