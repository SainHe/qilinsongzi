<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use app\admin\model\Admin as AdminModel;
class Login extends Controller
{
	public function index()
	{
		return view();
	}
	public function login()
	{

		$admin = new AdminModel();
		// 登录接口
		$request = Request::instance();
		if ($request->isPost()) {	// 判断是否post请求
			$res = $admin->adminFind(['userName'=>$request->post('username'),'passWord'=>md5($request->post('password'))]);
			$adminId = $res['id'];
			$loginNum = $res['loginNum']+1;
			$userStatus = $res['userStatus'];
			$admin->adminEdit($adminId,[
				'loginNum' => $loginNum,
				'lastIP' => $request->ip(),
				'lastTime' => date('Y-n-j H:i:s'),
			]);
			if($userStatus == 1){
				session('id',$res['id']);
				session('name',$res['nickName']);
				return json_encode(['code'=>1, 'message'=>'登录成功'],JSON_UNESCAPED_UNICODE);
			}else if($userStatus == 2){
				return json_encode(['code'=>2, 'message'=>'用户已被禁用'],JSON_UNESCAPED_UNICODE);
			}else{
				return json_encode(['code'=>0, 'message'=>'账户或密码错误'],JSON_UNESCAPED_UNICODE);
			}
		}
	}
	// 退出登录
	public function logout()
	{
		session(null);
		return 1;
	}
}
