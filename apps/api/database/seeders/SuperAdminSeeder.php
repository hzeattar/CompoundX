<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->updateOrCreate(
            ['email' => env('SUPER_ADMIN_EMAIL', 'admin@compoundx.local')],
            [
                'name' => env('SUPER_ADMIN_NAME', 'CompoundX Super Admin'),
                'password' => env('SUPER_ADMIN_PASSWORD', 'ChangeMe123!'),
                'preferred_locale' => 'en',
                'is_active' => true,
            ],
        );

        $user->assignRole('super-admin');
    }
}
