@extends('install/layouts/app')

@section('title', '系统配置')

@section('content')
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-[768px] w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
            <div class="text-center">
                <h1 class="font-['Pacifico'] text-3xl text-primary mb-2">logo</h1>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">图床安装向导</h2>
            </div>
            <div class="relative">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-8 h-8 bg-primary text-white rounded-full">1</div>
                        <div class="ml-2 font-medium text-primary">环境检查</div>
                    </div>
                    <div class="flex-1 mx-4">
                        <div class="h-1 bg-gray-200">
                            <div class="h-1 bg-primary w-full"></div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div id="stp2-number"
                             class="flex items-center justify-center w-8 h-8 bg-primary text-white rounded-full">2
                        </div>
                        <div id="stp2-text" class="ml-2 font-medium text-primary">系统配置</div>
                    </div>
                </div>

                @if (!empty($errors))
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">表单提交错误</h3>
                                <ul class="list-disc list-inside mt-2 text-sm text-red-700">
                                    @foreach ($errors as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form class="space-y-6" action="/install/config" method="post">
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-medium mb-4">域名配置</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="domain">
                                    网站域名，末尾不加 "/"
                                </label>
                                <input id="domain"
                                       type="text"
                                       name="domain"
                                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                       value="{{ (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://' . request()->host(true) }}"
                                       placeholder="网站域名与图片链接域名可以不同，比如A域名上传，可以返回B域名图片链接，如果不变的话，下边2个填写成一样的！"
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="img_domain">
                                    图片链接域名，末尾不加 "/"
                                </label>
                                <input id="img_domain"
                                       type="text"
                                       name="img_domain"
                                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                       value="{{ (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://' . request()->host(true) }}"
                                       placeholder="给图片的域名，末尾不加/，如果没有请填写和上边的一样即可">
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-medium mb-4">管理员配置</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1"
                                       for="username">用户名</label>
                                <input id="username" type="text" name="username" autocomplete="username"
                                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                       placeholder="请设置管理员用户名">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1"
                                       for="password">密码</label>
                                <input id="password" type="password" name="password" autocomplete="new-password"
                                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                       placeholder="请设置管理员密码">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1"
                                       for="password_confirm">确认密码</label>
                                <input id="password_confirm" type="password" name="password_confirm"
                                       autocomplete="new-password"
                                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                       placeholder="请再次输入密码">
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="delete_extra_files" name="delete_extra_files" value="yes" class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <label for="delete_extra_files" class="ml-2 block text-sm text-gray-900">删除多余的文件</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="delete_install_files" name="delete_install_files" value="yes" class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <label for="delete_install_files" class="ml-2 block text-sm text-gray-900">删除安装目录</label>
                        </div>
                    </div>
                </form>



                <div class="mt-8 flex justify-between">
                    <a href="/install" class="px-6 py-2 border border-gray-300 text-base font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary whitespace-nowrap">
                        上一步
                    </a>
                    <button id="installBtn"
                            class="px-6 py-2 border border-transparent text-base font-medium rounded text-white bg-primary hover:bg-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary whitespace-nowrap">
                        开始安装
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const installBtn = document.getElementById('installBtn');

        // 开始安装
        installBtn.addEventListener('click', (event) => {
            console.log(2333);
            event.preventDefault();
            document.querySelector('form').submit();
        });
    </script>
@endpush
