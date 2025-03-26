<?php

namespace app\controller;

use support\Request;

class UploadController
{
    public function index(Request $request)
    {
        return response(__CLASS__);
    }

}
