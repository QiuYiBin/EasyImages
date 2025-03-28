<?php
declare(strict_types=1);

namespace app\validate;

use think\Validate;

class Install extends Validate
{
    protected $rule =   [
        'domain'  => 'require',
        'img_domain'   => 'require',
        'username' => 'require',
        'password' => 'require|confirm',
    ];

    protected $message  =   [
        'domain.require' => '域名必须',
        'img_domain.require' => '域名必须',
        'username.require' => '管理员用户名必须',
        'password.require' => '管理员密码必须',
        'password.confirm' => '两次密码不一致',
    ];
}