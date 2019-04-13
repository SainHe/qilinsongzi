<?php
namespace app\admin\model;
use think\Model;
class Article extends Model
{
	// 获取列表
	public function articleGet(){
		return $this::paginate(10);
	}
	// 创建
	public function articleAdd($data){
		return $this->save($data);
	}
	// 获取单条信息
	public function articleFind($data){
		return $this::where($data)->find();
	}

	// 删除
	public function articleRemove($articleId){
		return $this::where('id',$articleId)->delete();
	}
	// 修改
	public function articleedit($articleId,$data){
		return $this::where('id',$articleId)->update($data);
	}
}
