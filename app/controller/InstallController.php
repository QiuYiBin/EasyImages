<?php

namespace app\controller;

use app\validate\Install;
use support\Request;
use support\Response;

class InstallController
{
    protected function checkIsInstalled(): bool
    {
        return is_file(public_path('install/lock/install.lock'));
    }

    public function index(): Response
    {
        if ($this->checkIsInstalled()) {
            return response('<script>window.alert("已安装系统，如需重新安装请删除文件！[public/install/lock/install.lock]");location.href="/";</script>');
        }

        // PHP环境 >= 8.2.0
        $phpEnv = !version_compare(phpversion(), '8.2.0', '<');

        // fileInfo扩展是否存在
        $fileInfoExtensionIsExist = extension_loaded('fileinfo');

        // GD扩展是否存在
        $gdExtensionIsExist = extension_loaded('gd');

        // openssl 扩展是否存在
        $openSSLExtensionIsExist = extension_loaded('openssl');

        // 图片目录权限是否正确
        $imagesPathPermission = true;

        if (PHP_OS !== 'WINNT') {
            $imagesPathPermission = str_ends_with(sprintf('%o', fileperms(public_path(config('upload.path')))), '0755');
        }

        return view('install/index',
            compact('phpEnv',
                'fileInfoExtensionIsExist',
                'gdExtensionIsExist',
                'openSSLExtensionIsExist',
                'imagesPathPermission'
            ));
    }

    public function config(Request $request): Response
    {
        if ($this->checkIsInstalled()) {
            return response('<script>window.alert("已安装系统，如需重新安装请删除文件！[public/install/lock/install.lock]");location.href="/";</script>');
        }

        if ($request->isPost()) {
            $validate = new Install;
            if (!$validate->batch()->check($request->post())) {
                return view('install/config', ['errors' => $validate->getError()]);
            }

            // 配置文件路径
            $configPath = config_path('upload.php');

            // 读取当前配置
            $config = include $configPath;

            $config['domain'] = $request->input('domain');

            $config['img_domain'] = $request->input('img_domain');

            $config['username'] = $request->input('username');

            $config['password'] = password_hash($request->input('password'), PASSWORD_DEFAULT);

            // 生成 PHP 配置文件内容（默认是 array(...) 格式）
            $configContent = "<?php\n\nreturn " . var_export($config, true) . ";\n";

            // 替换 array(...) 为短数组 [...]
            $configContent = str_replace(['array (', ')'], ['[', ']'], $configContent);

            // 写入文件
            file_put_contents($configPath, $configContent);

            // 删除安装控制器
            if ($request->input('delete_install_files') && $request->input('delete_install_files') === 'yes') {
                @unlink(app_path('controller/InstallController.php'));
                @unlink(app_path('view/install/step1.blade.php'));
                @unlink(app_path('view/install/step2.blade.php'));
                @unlink(app_path('view/install/layouts/app.blade.php'));
                @rmdir(app_path('view/install'));
            }

            // 删除多余文件
            //if ($request->input('delete_extra_files') && $request->input('delete_extra_files') === 'yes') {
            //
            //}

            //  处理安装文件
            $installPath = public_path('install') . DIRECTORY_SEPARATOR;
            !is_dir($installPath) && @mkdir($installPath);
            !is_dir($installPath . 'lock' . DIRECTORY_SEPARATOR) && @mkdir($installPath . 'lock' . DIRECTORY_SEPARATOR);
            @file_put_contents($installPath . 'lock' . DIRECTORY_SEPARATOR . 'install.lock', date('Y-m-d H:i:s'));

            return redirect('/');
        }

        return view();
    }
}
