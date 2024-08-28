<?php

namespace SmallRuralDog\Admin\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Storage;

class HandleController extends AdminBase
{

    public array $noNeedPermission = ['action', 'uploadImage', 'uploadFile'];


    public function action(Request $request)
    {
        try {
            $data = $request->all();
            $request->validate([
                'action' => 'required|string',
                'class' => 'required|string',
                'data' => 'array',
            ]);
            $class = base64_decode($data['class']);
            $action = $data['action'];
            $data = $data['data'];
            $res = (new $class())->$action($request, $data);
            return $res ?? amis_success("请求成功");
        } catch (Exception $e) {
            return amis_error($e->getMessage());
        }
    }


    public function uploadImage(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'file' => 'mimes:' . config('admin.upload.mimes', 'jpeg,bmp,png,gif,jpg')
            ]);
            return $this->upload($request);

        } catch (Exception $exception) {
            return amis_error($exception->getMessage());
        }
    }

    public function uploadFile(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'file' => 'mimes:' . config('admin.upload.file_mimes', '')
            ]);
            return $this->upload($request);

        } catch (Exception $exception) {
            return amis_error($exception->getMessage());
        }
    }


    protected function upload(Request $request)
    {
        try {
            $file = $request->file('file');
            $type = $request->file('type');
            $path = $request->input('path', 'images');
            $uniqueName = $request->boolean('unique_name', config('admin.upload.uniqueName', true));
            $disk = config('admin.upload.disk');
            $name = $file->getClientOriginalName();
            if ($uniqueName) {
                $path = $file->store($path, $disk);
            } else {
                $path = $file->storeAs($path, $name, $disk);
            }
            abort_if(!$path, 400, '上传失败');

            $url = Storage::disk($disk)->url($path);

            $data = [
                'value' => $path,
                'filename' => $name,
                'url' => $url,
                'link' => $url,
            ];
            return amis_data($data);
        } catch (Exception $exception) {
            return amis_error($exception->getMessage());
        }

    }
}
