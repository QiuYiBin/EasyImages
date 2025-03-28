<?php

namespace app\controller;

use Ramsey\Uuid\Uuid;
use support\Redis;
use support\Request;
use support\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use TusPhp\Tus\Server;

class UploadController
{
    private Server $server;

    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $file = $request->file('file');

        if ($file && $file->isValid()) {

            $filename = md5(uniqid()) . '.' . $file->getUploadExtension();

            $file->move(public_path(config('upload.path')) . $filename);

            return json(['success' => true, 'path' => config('upload.path'), 'filename' => $filename, 'url' => 'http://' . $request->host() . config('upload.path') . $filename]);
        }

        return response(json_encode(['success' => false, 'message' => '上传失败'], JSON_UNESCAPED_UNICODE), 400, ['Content-Type' => 'application/json']);
    }

    public function tus(Request $request)
    {
        $server = new Server('redis');
        $server->setApiPath('/upload/tus')
            ->setUploadDir(public_path('/images'))
            ->setRequest($request);
        $response = $server->serve();
        return response('', $response->getStatusCode(), $response->headers->all());
    }
}
