<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;

function admin_path(string $path = ''): string
{
    return ucfirst(config('admin.path')) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
}

function admin_base_path($path = ''): string
{
    $prefix = '/' . trim(config('admin.route.prefix'), '/');
    $prefix = ($prefix === '/') ? '' : $prefix;
    $path = trim($path, '/');
    if (is_null($path) || $path === '') {
        return $prefix ?: '/';
    }
    return $prefix . '/' . $path;
}

function admin_url($path = '', $parameters = [], $secure = null)
{
    if (URL::isValidUrl($path)) {
        return $path;
    }
    $secure = $secure ?: (config('admin.https') || config('admin.secure'));
    return url(admin_base_path($path), $parameters, $secure);
}

function amis_data(array|string|int|float|bool $data): JsonResponse
{
    return response()->json([
        'status' => 0,
        'data' => $data
    ]);
}

function amis_error(string|array $error, int $status = 400): JsonResponse
{
    return response()->json([
        'status' => $status,
        'error' => $error
    ]);
}


function vite_assets(): HtmlString
{
    $viteUrl = env("VITE_URL");
    if ($viteUrl) {
        if (!str_ends_with($viteUrl, '/')) {
            $viteUrl .= "/";
        }
        return new HtmlString(<<<HTML
            <script type="module" src="$viteUrl@vite/client"></script>
            <script type="module" src="{$viteUrl}src/main.ts"></script>
        HTML
        );
    }

    return new HtmlString(<<<HTML
    <script type="module" crossorigin src="/admin/assets/BpTLdzrt.js"></script>
    <link rel="modulepreload" crossorigin href="/admin/assets/7ce62ioI.js">
    <link rel="stylesheet" crossorigin href="/admin/assets/DDgZjSzH.css">
    <link rel="stylesheet" crossorigin href="/admin/assets/Dr7rAe4W.css">
    HTML
    );
}
