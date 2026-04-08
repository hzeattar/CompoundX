<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    public function test_tenant_data_stays_isolated(): void
    {
        $alpha = $this->provisionTenant(
            'tenant_alpha',
            'alpha.compoundx.test',
            [
                'name' => 'tenant_alpha',
                'default_locale' => 'en',
            ],
        );
        $bravo = $this->provisionTenant(
            'tenant_bravo',
            'bravo.compoundx.test',
            [
                'name' => 'tenant_bravo',
                'default_locale' => 'en',
            ],
        );

        $alpha->run(function (): void {
            User::factory()->create([
                'email' => 'alpha@example.com',
            ]);
        });

        $alpha->run(function (): void {
            $this->assertSame(1, User::count());
        });

        $bravo->run(function (): void {
            $this->assertSame(0, User::count());
        });
    }
}
