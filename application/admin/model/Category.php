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
	public function catetree(){
		$cateres=$this->select();
		return $this->sort($cateres);
	}
	public function sort($data,$pid=0,$level=1,$parentName='根目录'){
		static $arr = array();
		foreach ($data as $key => $value) {
			if($value['pid']==$pid){
				$value['level']=$level;
				$value['parentName']=$this::where('id',$value['pid'])->field('categoryName')->find()['categoryName'];
				$arr[]=$value;
				$this->sort($data,$value['id'],$level+1);
			}
		}
		return $arr;
	}
}
