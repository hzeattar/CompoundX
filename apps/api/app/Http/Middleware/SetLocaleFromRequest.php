<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromRequest
{
    private const SUPPORTED_LOCALES = ['en', 'ar', 'ku'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header('X-Locale')
            ?? Auth::guard('api')->user()?->preferred_locale
            ?? tenant('default_locale')
            ?? $request->getPreferredLanguage(self::SUPPORTED_LOCALES)
            ?? config('app.locale');

        $resolvedLocale = in_array($locale, self::SUPPORTED_LOCALES, true)
            ? $locale
            : config('app.locale', 'en');

        app()->setLocale($resolvedLocale);
        $request->attributes->set('resolved_locale', $resolvedLocale);

        return $next($request);
    }
}
