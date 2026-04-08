<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['super-admin', 'compound-admin', 'manager', 'resident', 'vendor', 'guest'] as $roleName) {
            Role::findOrCreate($roleName, 'api');
        }
    }
}
