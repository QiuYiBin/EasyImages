@extends('install/layouts/app')

@section('title', '网站基础配置')

@push('styles')
    <style>
        :root {
            --form-horz-label-width: 200px;
        }
    </style>
@endpush

@section('content')
    <h1 class="my-5 pb-2.5 text-center border-b">{{ $appName }} {{ $appVersion }} 网站基础配置</h1>

    <div class="col-md-10 col-md-offset-2">
        <form class="form form-horz" action="/install/step3" method="post">
            <div class="form-row">
                <div class="w-1/2 form-group">
                    <label class="form-label required" for="domain">网站域名，末尾不加 "/"</label>
                    <input id="domain" type="url" name="domain" class="form-control"
                           value="{{ (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://' . request()->host(true) }}"
                           placeholder="网站域名与图片链接域名可以不同，比如A域名上传，可以返回B域名图片链接，如果不变的话，下边2个填写成一样的!"
                           onkeyup="this.value=this.value.replace(/\s/g,'')" required/>
                </div>
            </div>

            <div class="form-row">
                <div class="w-1/2 form-group">
                    <label class="form-label required" for="img_domain">图片链接域名，末尾不加 "/"</label>
                    <input id="img_domain" type="url" name="img_domain" class="form-control"
                           value="{{ (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://' . request()->host(true) }}"
                           placeholder="给图片的域名，末尾不加/，如果没有请填写和上边的一样即可"
                           onkeyup="this.value=this.value.replace(/\s/g,'')" required/>
                </div>
            </div>

            <div class="form-row">
                <div class="w-1/2 form-group">
                    <label class="form-label required" for="username">管理账号</label>
                    <input id="username" type="text" name="username" class="form-control"
                           placeholder="请以大小写英文或数字输入管理员账号"
                           onkeyup="this.value=this.value.replace(/[^\w\.\/]/ig,'')" required/>
                </div>
            </div>

            <div class="form-row">
                <div class="w-1/2 form-group">
                    <label class="form-label required" for="password">管理密码</label>
                    <input id="password" type="password" name="password" class="form-control"
                           placeholder="请使用英文输入法输入密码并不小于8位数"
                           onkeyup="this.value=this.value.replace(/\s/g,'')" required/>
                    <label class="form-tip">请输入8-18位密码</label>
                </div>
            </div>

            <div class="form-row">
                <div class="w-1/2 form-group">
                    <label class="form-label required" for="confirm_password">确认密码</label>
                    <input id="confirm_password" type="password" name="confirm_password" class="form-control"
                           placeholder="再次输入管理密码" onkeyup="this.value=this.value.replace(/\s/g,'')" required/>
                    <label class="form-tip">请输入8-18位密码</label>
                </div>
            </div>

            <div class="form-row">
                <div class="w-1/2 form-group">
                    <div class="check-list-inline">
                        <label class="checkbox">
                            <input type="checkbox" name="delete_install_files" value="yes"><span class="text-primary">删除多余文件</span>
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" name="delete_extra_files" value="yes"><span class="text-danger">删除安装目录</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="gap-4 form-group">
                    <a href="/install/step1">
                        <button type="submit" class="btn">上一步</button>
                    </a>
                    <button type="submit" class="btn primary">开始安装</button>
                </div>
            </div>

        </form>
    </div>
@endsection