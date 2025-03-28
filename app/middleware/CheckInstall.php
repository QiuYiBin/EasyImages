<?php
namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

class CheckInstall implements MiddlewareInterface
{
    public function process(Request $request, callable $handler) : Response
    {
        // 检测安装控制器
        if (in_array('InstallController', explode('\\', $request->controller))) return $handler($request);

        // 没有安装则跳转到安装页面
        if (!is_file(public_path('install/lock/install.lock'))) {
            return redirect('/install');
        }

        return $handler($request);
    }
    
}
