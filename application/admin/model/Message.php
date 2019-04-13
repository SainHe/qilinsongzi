<?php
namespace app\admin\model;
use think\Model;
class Message extends Model
{
	// 获取列表
	public function messageGet(){
		return $this::paginate(10);
	}
	// 创建
	public function messageAdd($data){
		return $this->save($data);
	}
	// 获取单条信息
	public function messageFind($data){
		return $this::where($data)->find();
	}

	// 删除
	public function messageRemove($messageId){
		return $this::where('id',$messageId)->delete();
	}
	// 修改
	public function messageedit($cateId,$data){
		return $this::where('id',$cateId)->update($data);
	}
}
