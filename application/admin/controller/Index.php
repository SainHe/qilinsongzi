<?php
namespace app\admin\controller;
use think\Request;
use app\admin\model\Admin as AdminModel;
use app\admin\controller\Common;
class Index extends Common
{
    public function index($name = '张三', $sex='女')
    {
		return view('index');
    }
}
