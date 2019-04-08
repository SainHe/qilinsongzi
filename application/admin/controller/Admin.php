<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
//use think\Db;
use app\admin\model\Admin as AdminModel;
class Admin extends Controller
{
	public function admin()
	{
		// 管理员列表页
		$admin = new AdminModel();
		$res = $admin->getadmin();
		$this->assign('res',$res);
		return view();
	}
	public function changestatus(){
		// 改变状态
		$admin = new AdminModel();
		$adminId = input('post.id');
		$adminStatus = input('post.status');
		$res = $admin->changestatus($adminId,$adminStatus);
		if($res){
			return json_encode(['code'=>1,'message'=>urlencode('状态修改成功')]);
		}else{
			return json_encode(['code'=>0,'message'=>urlencode('状态修改失败')]);
		}
	}
	public function add()	// 添加管理员
	{
		$request = Request::instance();
		$admin = new AdminModel();
		if ($request->isPost()) {	// 判断是否post请求
			// 判断用户名是否重复？
			$adminname = input('post.username');
			$isName = $admin->findadmin($adminname);

			if($isName){
				return json_encode(['code'=>3,'message'=>urlencode('用户名已存在')]);
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
				return json_encode(['code'=>1,'message'=>urlencode('添加管理员成功')]);
			}else{
				return json_encode(['code'=>0,'message'=>urlencode('添加管理员失败')]);
			}
		}
		return;
	}
	public function findAdmin()
	{
		// 根据传入ID查询单条数据
		$request = Request::instance();
		if ($request->isPost()) {
			$adminId = $request->post('id');
			$res = db('admin')->where('id',$adminId)->find();
			return json_encode($res);
		}
		
	}
	
	public function edit()
	{
		// 修改管理员信息
		$request = Request::instance();
		if ($request->isPost()) {
			$adminId = $request->post('id');
			$nickName = $request->post('nickname');
			$userStatus = $request->post('userStatus');
			if($request->post('password')){
				$passWord = md5($request->post('password'));
				db('admin')->where('id',$adminId)->update([
					'passWord' => $passWord,
				]);
			}
			$res = db('admin')->where('id',$adminId)->update([
					'nickName' => $nickName,
					'userStatus' => $userStatus,
				]);
				if($res){
					return json_encode(['1'=>'success']);
				}else{
					return json_encode(['0'=>'error']);
				}
			return;
		}
	}
	public function login()
	{
		// 登录接口
		$request = Request::instance();
		if ($request->isPost()) {	// 判断是否post请求
			$res = db('admin')
					->where('userName',$request->post('username'))
					->where('passWord',md5($request->post('password')))
					->find();
			$adminId = $res['id'];
			$loginNum = $res['loginNum']+1;
			$userStatus = $res['userStatus'];
			db('admin')->where('id',$adminId)->update([
				'loginNum' => $loginNum,
				'lastIP' => $request->ip(),
				'lastTime' => date('Y-n-j H:i:s'),
			]);
			if($userStatus == 1){
				return json_encode(['code'=>'1', 'msg'=>'登录成功']);
			}else if($userStatus == 2){
				return json_encode(['code'=>'2', 'msg'=>'用户已禁用']);
			}else{
				return json_encode(['code'=>'0', 'msg'=>'登录失败']);
			}
		}
			
	}
}
