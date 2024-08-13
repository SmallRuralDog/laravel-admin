<?php

use Illuminate\Http\JsonResponse;

function admin_path(string $path = ''): string
{
    return ucfirst(config('admin.path')) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
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
