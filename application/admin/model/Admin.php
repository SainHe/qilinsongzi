<?php
namespace app\admin\model;
use think\Model;
class Admin extends Model
{
	public function addAdmin($data){
		if(empty($data) || !is_array($data)){
			return false;
		}
		if($this->save($data)){
			return true;
		}else{
			return false;
		}
	}
	public function getAdmin(){
		return $this::select();
	}
	public function findAdmin($data){
		if($this::where('userName',$data)->find()){
			return true;
		}else{
			return false;
		}
	}
	public function changeStatus($adminId,$adminStatus){
		if($this::where('id',$adminId)->update(['userStatus' => $adminStatus])){
			return true;
		}else{
			return false;
		}
	}
}