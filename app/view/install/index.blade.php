@extends('install/layouts/app')

@section('title', '环境检查')

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
                            <div id="processBar" class="h-1 bg-primary" style="width: 50%"></div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div id="stp2-number"
                             class="flex items-center justify-center w-8 h-8 bg-gray-200 text-gray-500 rounded-full">2
                        </div>
                        <div id="stp2-text" class="ml-2 font-medium text-gray-500">系统配置</div>
                    </div>
                </div>
                <div id="step1" class="space-y-6">
                    <div class="space-y-4">
                        <x-install.check :status="$phpEnv" title="PHP版本检查"
                                         description="要求PHP >= 8.2.0" :statusTrueText="'PHP' . phpversion()"
                                         :statusFalseText="'PHP' . phpversion()"/>

                        <x-install.check :status="$fileInfoExtensionIsExist" title="fileinfo 扩展"
                                         description="图片处理必须安装 fileinfo 扩展" statusTrueText="已安装"
                                         statusFalseText="未安装"/>

                        <x-install.check :status="$gdExtensionIsExist" title="GD 扩展" description="图片处理必须安装 GD 扩展"
                                         statusTrueText="已安装" statusFalseText="未安装"/>

                        <x-install.check :status="$openSSLExtensionIsExist" title="OpenSSL 扩展"
                                         description="加密必须安装 OpenSSL 扩展" statusTrueText="已安装"
                                         statusFalseText="未安装"/>

                        <x-install.check :status="$imagesPathPermission" title="上传目录权限"
                                         :description="config('upload.path') . '目录需要写入权限'" statusTrueText="可写"
                                         statusFalseText="权限错误"/>
                    </div>

                    @php
                        $errors = [];
                        if (!$phpEnv) $errors[] = 'PHP 版本低于最低要求 8.2.0';
                        if (!$fileInfoExtensionIsExist) $errors[] = '未安装必要的 fileinfo 扩展';
                        if (!$gdExtensionIsExist) $errors[] = '未安装必要的 GD 扩展';
                        if (!$openSSLExtensionIsExist) $errors[] = '未安装必要的 OpenSSL 扩展';
                        if (!$imagesPathPermission) $errors[] = config('upload.path') . ' 目录无写入权限';
                    @endphp


                    @if (!empty($error))
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-500"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">环境检查未通过</h3>
                                    <p class="mt-2 text-sm text-red-700">系统检测到以下问题需要解决：</p>
                                    <ul class="list-disc list-inside mt-2 text-sm text-red-700">
                                        @foreach ($errors as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-green-500"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800">环境检查通过</h3>
                                    <p class="mt-2 text-sm text-green-700">
                                        所有必要的系统要求都已满足，您可以继续下一步操作。</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="flex justify-center mt-6">
                        <button id="reloadBtn"
                                class="px-6 py-2 border border-gray-300 text-base font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary whitespace-nowrap">
                            <i class="fas fa-sync-alt mr-2"></i>重新检测
                        </button>
                    </div>
                </div>

                <div class="mt-8 flex justify-between">
                    @if (empty($errors))
                    <a href="/install/config"
                       class="px-6 py-2 border border-transparent text-base font-medium rounded text-white bg-primary hover:bg-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary whitespace-nowrap">
                        下一步
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const reloadBtn = document.getElementById('reloadBtn');
        reloadBtn.addEventListener('click', () => location.reload());
    </script>
@endpush
