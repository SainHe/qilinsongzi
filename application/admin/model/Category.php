<?php
namespace app\admin\model;
use think\Model;
class Category extends Model
{
	// 获取栏目列表
	public function categoryGet(){
		return $this::select();
	}
	// 创建栏目
	public function categoryAdd($data){
		return $this->save($data);
	}
	// 获取单条栏目信息
	public function categoryFind($data){
		return $this::where($data)->find();
	}

	// 删除栏目
	public function categoryRemove($adminId){
		return $this::where('id',$adminId)->delete();
	}
	// 修改栏目
	public function categoryEdit($cateId,$data){
		return $this::where('id',$cateId)->update($data);
	}
}
