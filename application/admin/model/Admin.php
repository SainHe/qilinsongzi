<?php
namespace app\admin\model;
use think\Model;
class Admin extends Model
{
	// 创建管理员
	public function addAdmin($data){
		if(empty($data) || !is_array($data)){
			return false;
		}
		return $this->save($data);
	}
	// 分页
	public function adminGet(){
		return $this::paginate(10);
	}

	// 获取管理员信息、管理员登录
	public function adminFind($data){
		return $this::where($data)->find();
	}
	// 修改管理员
	public function adminEdit($adminId,$data){
		return $this::where('id',$adminId)->update($data);
	}
	// 删除管理员
	public function adminRemove($adminId){
		return $this::where('id',$adminId)->delete();
	}
}
