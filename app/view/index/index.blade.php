@extends('index/layouts/app')

@section('title', '简单图床')

@push('styles')
    <link href="https://releases.transloadit.com/uppy/v4.13.3/uppy.min.css" rel="stylesheet">
    <style>
        #upload-status {
            margin-top: 10px;
            font-size: 14px;
            color: green;
        }
    </style>
@endpush

@section('content')
    <div id="uppy-dashboard"></div>
    <div id="status-bar"></div>
    <div id="upload-status"></div>
@endsection

@push('scripts')
    <script type="module">
        import {Uppy, Dashboard, XHRUpload, Tus} from "https://releases.transloadit.com/uppy/v4.13.3/uppy.min.mjs"
        // 设置中文语言
        const uppyStrings = {
            "addBulkFilesFailed": "内部错误导致添加 %{smart_count} 个文件失败",
            "addMore": "添加更多文件",
            "addMoreFiles": "添加更多文件",
            "addingMoreFiles": "添加更多文件",
            "allowAccessDescription": "为了通过您的相机进行拍照或录像，请给予网站相机的访问权限",
            "allowAccessTitle": "请允许对相机的访问权限",
            "authenticateWith": "连接到 %{pluginName}",
            "authenticateWithTitle": "请使用 %{pluginName} 进行认证以选择文件",
            "back": "返回",
            "browse": "浏览",
            "browseFiles": "浏览",
            "cancel": "取消",
            "cancelUpload": "取消上传",
            "chooseFiles": "选择文件",
            "closeModal": "关闭窗口",
            "companionError": "和 Companion 连接失败了",
            "companionUnauthorizeHint": "请访问 %{url} 以认证您的 %{provider} 账户",
            "complete": "上传完毕",
            "connectedToInternet": "连接至网络",
            "copyLink": "复制链接",
            "copyLinkToClipboardFallback": "复制以下网址",
            "copyLinkToClipboardSuccess": "链接已复制到剪贴板",
            "creatingAssembly": "正在准备上传…",
            "creatingAssemblyFailed": "Transloadit：无法创建程序集",
            "dashboardTitle": "文件上传工具",
            "dashboardWindowTitle": "文件上传工具窗口（点击离开以关闭）",
            "dataUploadedOfTotal": "%{total} / %{complete}",
            "done": "完成",
            "dropHereOr": "拖拽文件到这里，或%{browse}",
            "dropHint": "拖拽文件到这里",
            "dropPasteBoth": "拖拽文件到这里，或者%{browse}文件",
            "dropPasteFiles": "拖拽文件到这里，或者%{browse}文件",
            "dropPasteFolders": "拖拽文件到这里，或者%{browse}文件",
            "dropPasteImportBoth": "拖拽文件到这里，粘贴、%{browse}或者导入",
            "dropPasteImportFiles": "拖拽文件到这里，粘贴、%{browse}或者导入",
            "dropPasteImportFolders": "拖拽文件到这里，粘贴、%{browse}或者导入",
            "editFile": "编辑文件",
            "editing": "正在编辑 %{file}",
            "emptyFolderAdded": "无法从空文件夹添加文件",
            "encoding": "正在编码…",
            "enterCorrectUrl": "错误链接：请确认您输入的是文件的链接",
            "enterUrlToImport": "输入链接或者导入文件",
            "exceedsSize": "文件超过了最大尺寸限制 %{size}",
            "failedToFetch": "Companion 无法抓取此链接，请确保它是正确的",
            "failedToUpload": "上传 %{file} 失败",
            "fileSource": "文件源：%{name}",
            "filesUploadedOfTotal": "已上传 %{smart_count} 个文件中的 %{complete} 个",
            "filter": "筛选器",
            "finishEditingFile": "完成文件编辑",
            "folderAdded": "从 %{folder} 添加了 %{smart_count} 个文件",
            "generatingThumbnails": "正在生成缩略图…",
            "import": "导入",
            "importFrom": "从 %{name} 导入",
            "inferiorSize": "文件大小必须超过 %{size}",
            "loading": "正在加载…",
            "logOut": "登出",
            "micDisabled": "麦克风的权限访问被用户拒绝",
            "myDevice": "我的设备",
            "noCameraDescription": "为了拍摄照片或录制视频，请连接一个摄像设备",
            "noCameraTitle": "摄像头不可用",
            "noDuplicates": "无法添加重复文件 %{fileName}，该文件已存在",
            "noFilesFound": "这里空空如也",
            "noInternetConnection": "无法连接到网络",
            "noMoreFilesAllowed": "无法添加新文件：已正在上传文件",
            "openFolderNamed": "打开文件夹 %{name}",
            "pause": "暂停",
            "pauseUpload": "暂停上传",
            "paused": "已暂停",
            "poweredBy": "强力驱动于 %{uppy}",
            "processingXFiles": "正在处理 %{smart_count} 个文件",
            "recording": "正在录制",
            "recordingLength": "录制长度 %{recording_length}",
            "recordingStoppedMaxSize": "录像已停止，文件大小即将超过限制",
            "removeFile": "删除文件",
            "resetFilter": "重置筛选器",
            "resume": "恢复",
            "resumeUpload": "恢复上传",
            "retry": "重试",
            "retryUpload": "重试上传",
            "saveChanges": "保存更改",
            "selectFileNamed": "选择文件 %{name}",
            "selectX": "选择 %{smart_count}",
            "smile": "笑一笑！",
            "startCapturing": "开始屏幕录制",
            "startRecording": "开始视频录制",
            "stopCapturing": "停止屏幕录制",
            "stopRecording": "停止视频录制",
            "streamActive": "视频流已激活",
            "streamPassive": "视频流未激活",
            "submitRecordedFile": "提交已录制视频",
            "takePicture": "拍照",
            "timedOut": "上传已超时 %{seconds} 秒，中止上传",
            "unselectFileNamed": "取消选择文件 %{name}",
            "upload": "上传",
            "uploadComplete": "上传完成",
            "uploadFailed": "上传失败",
            "uploadPaused": "上传暂停",
            "uploadXFiles": "上传 %{smart_count} 个文件",
            "uploadXNewFiles": "新上传了 %{smart_count} 个文件",
            "uploading": "正在上传",
            "uploadingXFiles": "正在上传 %{smart_count} 个文件",
            "xFilesSelected": "%{smart_count} 个文件待上传",
            "xMoreFilesAdded": "又有 %{smart_count} 个文件被添加",
            "xTimeLeft": "剩余 %{time}",
            "youCanOnlyUploadFileTypes": "您只能上传这些文件类型：%{types}",
            "youCanOnlyUploadX": "您只能上传 %{smart_count} 个文件"
        };

        const uppy = new Uppy({
            debug: true,
            restrictions: {
                maxNumberOfFiles: 5,
                maxFileSize: 10 * 1024 * 1024, // 文件限制 10 MB
                allowedFileTypes: ['image/*']
            },
            autoProceed: false
        })

        // 添加 Dashboard UI
        uppy.use(Dashboard, {
            inline: true,
            width: "100%",
            target: "#uppy-dashboard",
            showProgressDetails: true,
            proudlyDisplayPoweredByUppy: false, // 隐藏 Uppy Logo
            locale: {strings: uppyStrings},
        });

        // 添加 XHR 直传
        // uppy.use(XHRUpload, {endpoint: "/upload", fieldName: "file"});

        // 添加分片上传（适用于大文件）
        uppy.use(Tus, {
            endpoint: "/upload/tus",
            // endpoint: "http://127.0.0.1:8080/files/",
            onBeforeRequest: (request) => {
                console.log('request', request)
            }
        });

        // 监听文件添加，自动填充重命名输入框
        uppy.on("file-added", (file) => {

        });

        // 上传前修改文件名
        uppy.on("before-upload", (files) => {
            Object.keys(files).forEach((fileID) => {
                const file = files[fileID];
                // if (renameInput.value) {
                //     uppy.setFileMeta(fileID, {name: renameInput.value});
                // }
            });
        });

        // 监听上传进度
        uppy.on("upload-progress", (file, progress) => {
            // document.getElementById("upload-status").innerText = `正在上传 ${file.name} (${Math.round(progress.bytesUploaded / progress.bytesTotal * 100)}%)`;
        });

        // 监听上传完成
        uppy.on("complete", (result) => {
            // let successFiles = result.successful.map(file => file.name).join(", ");
            // document.getElementById("upload-status").innerText = `上传成功：${successFiles}`;
        });

        // 监听文件移除
        uppy.on("file-removed", (file) => {
            console.log("文件已移除:", file.name);
        });
    </script>
@endpush