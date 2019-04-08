<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
class Index extends Controller
{
    public function index($name = '张三', $sex='女')
    {
		return view('index');	
    }
	public function login()
	{
		echo '1';
		if (Request::instance()->isPost()) return "当前为 POST 请求";
		//$data = Db::name('user')->find();
		//print_r($data);
	}
}
