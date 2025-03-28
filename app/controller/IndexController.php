<?php

namespace app\controller;

use support\Request;

class IndexController
{
    public function index(Request $request)
    {
        var_dump(request()->uri());
        return view('index/index');
    }

    public function view(Request $request)
    {
        return view('index/view', ['name' => 'webman']);
    }

    public function json(Request $request)
    {
        return json(['code' => 0, 'msg' => 'ok']);
    }

}
