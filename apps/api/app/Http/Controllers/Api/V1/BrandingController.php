<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandingController extends Controller
{
    public function __invoke(Request $request)
    {
        /** @var Tenant $tenant */
        $tenant = tenant();
        $tenant->loadMissing('domains');

        return ApiResponse::success(
            request: $request,
            data: [
                'tenant' => [
                    'id' => $tenant->getTenantKey(),
                    'name' => $tenant->name ?? Str::headline((string) $tenant->getTenantKey()),
                    'company_name' => $tenant->company_name ?? $tenant->name,
                    'primary_color' => $tenant->primary_color ?? '#123745',
                    'logo_url' => $tenant->logo_url,
                    'default_locale' => $tenant->default_locale ?? 'en',
                    'is_active' => (bool) ($tenant->is_active ?? true),
                    'domains' => $tenant->domains->pluck('domain')->values()->all(),
                ],
            ],
            message: 'Branding bootstrap loaded successfully.',
        );
    }
}
