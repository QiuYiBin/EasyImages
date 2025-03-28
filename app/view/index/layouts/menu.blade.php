<div class="pb-2.5 my-10">
    <menu class="nav nav-justified nav-pills">
        <li class="item nav-item"><a href="{{ request()->uri() === '/' ? '#' : '/' }}"  class="{{ request()->uri() === '/' ? ' active' : '' }}"><i class="icon icon-home"></i><span class="text">首页</span></a>
        </li>
        <li class="item nav-item"><a><span class="text">广场</span></a></li>
        <li class="item nav-item"><a><span class="text">历史</span></a></li>
        <li class="item nav-item"><a><span class="text">设置</span></a></li>
        <li class="item nav-item"><a><span class="text">统计</span></a></li>
        <li class="nav-space"></li>
        <li class="nav-space w-4 flex-none"></li>
        <li class="toolbar gap-2 xs:hidden">
            <a href="/login" class="btn bg-none rounded-full ghost">
                <i class="icon icon-user"></i>
                登录
            </a>
        </li>
    </menu>
</div>