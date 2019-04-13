<?php
namespace app\admin\controller;
use think\Request;
use app\admin\model\Message as MessageModel;
use app\admin\controller\Common;
class message extends Common
{
	public function index()
	{
		// 留言列表
		$message = new MessageModel();
		$res = $message->messageget();
		$this->assign('messageres',$res);
		return view();
	}

	public function findmessage()
	{
		// 根据传入ID查询单条数据
		$request = Request::instance();
		$message = new MessageModel();
		if ($request->isPost()) {
			$messageId = $request->post('id');
			$res = $message->messageFind(['id'=>$messageId]);
			return json_encode($res,JSON_UNESCAPED_UNICODE);
		}

	}

	public function edit()
	{
		// 修改留言
		$request = Request::instance();
		$message = new MessageModel();
		if ($request->isPost()) {
			$messageId = $request->post('id');
			$contacts = $request->post('contacts');
			$phone = $request->post('phone');
			$email = $request->post('email');
			$weixin = $request->post('weixin');
			$leaveContent = $request->post('leaveContent');


			$res = $message->messageedit($messageId,[
				'contacts' => $contacts,
				'phone' => $phone,
				'email' => $email,
				'weixin' => $weixin,
				'content' => $leaveContent,
			]);
			if($res){
				return json_encode(['code'=>'1','message'=>'修改成功'],JSON_UNESCAPED_UNICODE);
			}else{
				return json_encode(['code'=>'0','message'=>'修改失败'],JSON_UNESCAPED_UNICODE);
			}
			return;
		}
	}
	public function removemessage(){
		// 删除留言
		$request = Request::instance();
		$message = new MessageModel();
		if ($request->isPost()) {
			$messageId = $request->post('removeId');
			$res = $message->messageremove($messageId);
			if($res){
				return json_encode(['code'=>'1','message'=>'删除成功'],JSON_UNESCAPED_UNICODE);
			}else{
				return json_encode(['code'=>'0','message'=>'删除失败'],JSON_UNESCAPED_UNICODE);
			}
			return;
		}
	}
}
