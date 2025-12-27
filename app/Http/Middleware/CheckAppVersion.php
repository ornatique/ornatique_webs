<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AppSetting;
use Log;
class CheckAppVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
    $platform = $request->header('platform');
    $version  = $request->header('app-version');

    Log::info('App Version Check', [
        'platform' => $platform,
        'version' => $version,
        'url' => $request->fullUrl(),
        'ip' => $request->ip(),
    ]);

    // If headers missing → force update
    if (!$platform || !$version) {
        return response()->json([
            'status' => false,
            'code' => 'VERSION_REQUIRED',
            'message' => 'App update required'
        ], 426);
    }

    $settings = AppSetting::where('platform', $platform)->first();

    if (!$settings) {
        return $next($request);
    }

    // 🔥 FORCE UPDATE LOGIC
    if (
        $settings->force_update == 1 &&
        version_compare($version, $settings->latest_version, '<')
    ) {
        return response()->json([
            'status' => false,
            'code' => 'FORCE_UPDATE',
            'message' => 'Please update app to continue',
            'store_url' => $settings->store_url
        ], 426);
    }

    return $next($request);
}


}
