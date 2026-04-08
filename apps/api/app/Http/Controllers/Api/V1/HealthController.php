<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Support\ApiResponse;
use Illuminate\Http\Request;

class HealthController extends Controller
{
    public function __invoke(Request $request)
    {
        return ApiResponse::success(
            request: $request,
            data: [
                'status' => 'ok',
                'service' => config('app.name'),
                'environment' => config('app.env'),
            ],
            message: 'CompoundX API is reachable.',
        );
    }
}
