<?php
namespace app\admin\controller;
use think\Request;
use app\admin\model\Admin as AdminModel;
use app\admin\controller\Common;
class Admin extends Common
{
	public function index()
	{
		// 管理员列表页
		$admin = new AdminModel();
		$res = $admin->adminget();
		$this->assign('adminres',$res);
		return view();
	}
	public function changestatus(){
		// 改变状态
		$admin = new AdminModel();
		$adminId = input('post.id');
		$adminStatus = input('post.status');
		$res = $admin->adminedit($adminId,['userStatus' => $adminStatus]);
		if($res){
			return json_encode(['code'=>1,'message'=>'状态修改成功'],JSON_UNESCAPED_UNICODE);
		}else{
			return json_encode(['code'=>0,'message'=>'状态修改失败'],JSON_UNESCAPED_UNICODE);
		}
	}
	public function add()	// 添加管理员
	{
		$request = Request::instance();
		$admin = new AdminModel();
		if ($request->isPost()) {	// 判断是否post请求
			// 判断用户名是否重复？
			$adminname = input('post.username');
			$isName = $admin->adminfind(['userName'=>$adminname]);

			if($isName){
				return json_encode(['code'=>3,'message'=>'用户名已存在'],JSON_UNESCAPED_UNICODE);
			}
			$data = [
				'userName' => input('post.username'),
				'passWord' => md5(input('post.password')),
				'nickName' => input('post.nickname'),
				'userStatus' => input('post.static'),
				'loginNum' => 1,
				'lastIP' => $request->ip(),
				'lastTime' => date('Y-n-j H:i:s'),
				'creatTime' => date('Y-n-j H:i:s'),
			];
			$res = $admin->addadmin($data);
			if($res){
				return json_encode(['code'=>1,'message'=>'添加管理员成功'],JSON_UNESCAPED_UNICODE);
			}else{
				return json_encode(['code'=>0,'message'=>'添加管理员失败'],JSON_UNESCAPED_UNICODE);
			}
		}
		return;
	}
	public function findAdmin()
	{
		// 根据传入ID查询单条数据
		$request = Request::instance();
		$admin = new AdminModel();
		if ($request->isPost()) {
			$adminId = $request->post('id');
			$res = $admin->adminfind(['id'=>$adminId]);
			return json_encode($res,JSON_UNESCAPED_UNICODE);
		}

	}

	public function edit()
	{
		// 修改管理员信息
		$request = Request::instance();
		$admin = new AdminModel();
		if ($request->isPost()) {
			$adminId = $request->post('id');
			$nickName = $request->post('nickname');
			$userStatus = $request->post('status');
			if($request->post('password')){
				$passWord = md5($request->post('password'));
				$admin->adminedit($adminId,['passWord'=>$passWord]);
			}
			$res = $admin->adminedit($adminId,[
				'nickName' => $nickName,
				'userStatus' => $userStatus,
			]);
			if($res){
				return json_encode(['code'=>'1','message'=>'修改成功'],JSON_UNESCAPED_UNICODE);
			}else{
				return json_encode(['code'=>'0','message'=>'修改失败'],JSON_UNESCAPED_UNICODE);
			}
			return;
		}
	}
	public function removeAdmin(){
		// 删除管理员
		$request = Request::instance();
		$admin = new AdminModel();
		if ($request->isPost()) {
			$adminId = $request->post('removeId');
			$res = $admin->adminremove($adminId);
			if($res){
				return json_encode(['code'=>'1','message'=>'删除成功'],JSON_UNESCAPED_UNICODE);
			}else{
				return json_encode(['code'=>'0','message'=>'删除失败'],JSON_UNESCAPED_UNICODE);
			}
			return;
		}
	}
}
