<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;
use SmallRuralDog\Admin\Extensions\SettingStorage;

function admin_config(string $key)
{
    return config('admin.' . $key);
}

function admin_path(string $path = ''): string
{
    return ucfirst(config('admin.directory')) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
}

function admin_route($path = ''): string
{
    $prefix = trim(admin_config('route.prefix'));
    $path = str_replace($prefix . '/', '/', $path);
    return (string)Str::of($path)->finish('/')->start('/')->rtrim("/");
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

function admin_url($path = '', $parameters = [])
{
    if (URL::isValidUrl($path)) {
        return $path;
    }
    return url(admin_base_path($path), $parameters);
}

//给现有的 URL 拼接参数
function get_url_with_parameter($url, $parameters = [])
{
    //判断是否是 url
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return $url;
    }

    $url = parse_url($url);
    $query = [];
    if (isset($url['query'])) {
        parse_str($url['query'], $query);
    }
    $query = array_merge($query, $parameters);
    $url['query'] = http_build_query($query);

    $host = $url['host'] ?? '';
    $port = $url['port'] ?? '';
    $scheme = $url['scheme'] ?? '';
    $path = $url['path'] ?? '';
    $query = $url['query'] ?? '';

    if ($query) {
        $query = '?' . $query;
    }

    return $scheme . '://' . $host . ($port ? ':' . $port : '') . $path . $query;
}

function admin_file_url($path)
{
    if (!$path) {
        return $path;
    }
    if (Str::startsWith($path, ["http://", "https://"])) {
        return $path;
    }
    return Storage::disk(config('admin.upload.disk'))->url($path);
}

function admin_file_restore_path($url)
{
    if (!$url) {
        return $url;
    }
    if (Str::startsWith($url, ["http://", "https://"])) {
        $base_url = Storage::disk(config('admin.upload.disk'))->url('');
        $url = str_replace($base_url, '', $url);
    }
    return $url;
}

function amis_data($data, $status = 0): JsonResponse
{
    return response()->json([
        'status' => $status,
        "msg" => "",
        'data' => $data
    ]);
}

function amis_success(string $message = '操作成功'): JsonResponse
{
    return response()->json([
        'status' => 0,
        'msg' => $message,
        "data" => []
    ]);
}

function amis_error(string|array $error, int $status = 400): JsonResponse
{
    $res = [
        'status' => $status,
        "data" => []
    ];
    if (is_array($error)) {
        $res['errors'] = $error;
    } else {
        $res['msg'] = $error;
    }

    return response()->json($res);
}


/**
 * 数组转树
 * @param $list
 * @param string $id
 * @param string $pid
 * @param string $son
 * @return array
 */
function arr2tree($list, string $id = 'id', string $pid = 'parent_id', string $son = 'children'): array
{

    if (!is_array($list)) {
        $list = collect($list)->toArray();
    }

    [$tree, $map] = [[], []];
    foreach ($list as $item) {
        $map[$item[$id]] = $item;
    }

    foreach ($list as $item) {
        if (isset($item[$pid], $map[$item[$pid]])) {
            $map[$item[$pid]][$son][] = &$map[$item[$id]];
        } else {
            $tree[] = &$map[$item[$id]];
        }
    }
    unset($map);
    return $tree;
}

/**
 * 树转数组
 * @param $tree
 * @param string $son
 * @return array
 */
function tree2arr($tree, string $son = 'children'): array
{
    $list = [];
    foreach ($tree as $item) {
        $list[] = $item;
        if (isset($item[$son])) {
            $list = array_merge($list, tree2arr($item[$son], $son));
        }
    }
    return $list;
}

/**
 * 查找树的子节点
 * @param array $list
 * @param $id
 * @param string $son
 * @return array
 */
function find_tree_children(array $list, $id, string $son = 'children'): array
{
    foreach ($list as $item) {
        if ($item['id'] == $id) {

            return $item[$son] ?? [];
        }
        if (isset($item[$son])) {
            $children = find_tree_children($item[$son], $id, $son);
            if ($children) {
                return $children;
            }
        }
    }
    return [];
}

if (!function_exists('settings')) {

    function settings($key = null, $default = null)
    {
        $setting = app()->make(SettingStorage::class);
        if (is_null($key)) {
            return $setting;
        }
        if (is_array($key)) {
            return $setting->set($key);
        }
        return $setting->get($key, value($default));
    }
}

/**
 * 获取资源路由的中文名称
 * @param string $name
 * @return string
 */
function get_name_by_resource_route(string $name): string
{
    if (str_ends_with($name, '.index')) {
        return '列表';
    }
    if (str_ends_with($name, '.create')) {
        return '创建';
    }
    if (str_ends_with($name, '.edit')) {
        return '编辑';
    }
    if (str_ends_with($name, '.destroy')) {
        return '删除';
    }
    if (str_ends_with($name, '.show')) {
        return '详情';
    }
    if (str_ends_with($name, '.store')) {
        return '保存';
    }
    if (str_ends_with($name, '.update')) {
        return '更新';
    }
    return '';
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
    <script type="module" crossorigin src="/admin/assets/DwsKZaH3.js"></script>
    <link rel="modulepreload" crossorigin href="/admin/assets/JA_6wDNe.js">
    <link rel="stylesheet" crossorigin href="/admin/assets/DMDu9aLK.css">
    <link rel="stylesheet" crossorigin href="/admin/assets/BA_y0pdN.css">
    HTML
    );
}
