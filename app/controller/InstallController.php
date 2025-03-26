<?php

namespace app\controller;

use support\Request;

class InstallController
{
    public function step1(Request $request): \support\Response
    {
        // PHP环境 >= 8.2.0
        $phpEnv = !version_compare(phpversion(), '8.2.0', '<');

        // fileInfo扩展是否存在
        $fileInfoExtensionIsExist = extension_loaded('fileinfo');

        // GD扩展是否存在
        $gdExtensionIsExist = extension_loaded('gd');

        // 上传控制器权限是否正确
        $uploadControllerPermission = true;

        // openssl 扩展是否存在
        $openSSLExtensionIsExist = extension_loaded('openssl');

        // 图片目录权限是否正确
        $imagesPathPermission = true;

        // .user.ini 文件是否存在
        $userIniIsExist = !is_file(base_path('.user.ini'));

        if (PHP_OS !== 'WINNT') {
            $uploadControllerPermission = str_ends_with(sprintf('%o', fileperms(app_path('controller/UploadController.php'))), '0755');
            $imagesPathPermission = str_ends_with(sprintf('%o', fileperms(public_path('images'))), '0755');
        }

        return view('install/step1',
            compact('phpEnv', 'fileInfoExtensionIsExist', 'gdExtensionIsExist', 'uploadControllerPermission', 'openSSLExtensionIsExist', 'imagesPathPermission', 'userIniIsExist')
        );
    }

    public function step2(): \support\Response
    {
        return view('install/step2');
    }

    public function step3(Request $request)
    {
        var_dump($request->all());

        // 配置文件路径
        $configPath = config_path('upload.php');

        // 读取当前配置
        $config = include $configPath;

        if ($request->input('password') && $request->input('password') !== $request->input('confirm_password')) {
            return '<script>window.alert("两次密码不一致请重新输入!");location.href="/install/step2";</script>';
        } else {
            $config['password'] = password_hash($request->input('password'), PASSWORD_DEFAULT);
        }

        if ($request->input('domain')) {
            $config['domain'] = $request->input('domain');
        }

        if ($request->input('img_domain')) {
            $config['img_domain'] = $request->input('img_domain');
        }

        if ($request->input('username')) {
            $config['username'] = $request->input('username');
        }

        var_dump($config);

        // 生成 PHP 配置文件内容（默认是 array(...) 格式）
        $configContent = "<?php\n\nreturn " . var_export($config, true) . ";\n";

        // 替换 array(...) 为短数组 [...]
        $configContent = str_replace(['array (', ')'], ['[', ']'], $configContent);

        // 写入文件
        file_put_contents($configPath, $configContent);

        // 删除安装目录
        if ($request->input('delete_install_files') && $request->input('delete_install_files') === 'yes') {

        }

        // 删除多余文件
        if ($request->input('delete_extra_files') && $request->input('delete_extra_files') === 'yes') {

        }

        return redirect('/');

    }
}
