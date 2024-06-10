<?php
namespace app\api\controller;

use think\admin\Controller;

class BaseController extends Controller
{
    protected function _success($msg = '', $data = [])
    {
        return json(['success' => true, 'msg' => $msg, 'data' => $data]);
    }

    protected function _error($msg = '', $data = [])
    {
        return json(['success' => false, 'msg' => $msg, 'data' => $data]);
    }

}
