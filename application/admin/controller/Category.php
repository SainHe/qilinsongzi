<?php
namespace app\admin\controller;
use think\Request;
use app\admin\model\Category as CategoryModel;
use app\admin\controller\Common;
class category extends Common
{
	public function index()
	{
		// 栏目无限级分类
		$category = new CategoryModel();
		$res = $category->categoryGet();
		$this->assign('categoryres',$res);
		return view();
	}

	public function add()	// 添加栏目
	{
		$request = Request::instance();
		$category = new CategoryModel();
		if ($request->isPost()) {	// 判断是否post请求
			// 判断栏目名称是否重复？
			$categoryname = ['categoryName'=>input('post.catename')];
			$isName = $category->categoryFind($categoryname);

			if($isName){
				return json_encode(['code'=>3,'message'=>'栏目已存在'],JSON_UNESCAPED_UNICODE);
			}
			$data = [
				'categoryName' => input('post.catename'),
				'type' => 1,
				'pid' => input('post.pid'),
				'creatUser' => session('name'),
				'visit' => 1,
				'creatTime' => date('Y-n-j H:i:s'),
			];
			$res = $category->categoryadd($data);
			if($res){
				return json_encode(['code'=>1,'message'=>'添加栏目成功'],JSON_UNESCAPED_UNICODE);
			}else{
				return json_encode(['code'=>0,'message'=>'添加栏目失败'],JSON_UNESCAPED_UNICODE);
			}
		}
		return;
	}
	public function findcategory()
	{
		// 根据传入ID查询单条数据
		$request = Request::instance();
		$category = new CategoryModel();
		if ($request->isPost()) {
			$categoryId = $request->post('id');
			$res = $category->categoryFind(['id'=>$categoryId]);
			return json_encode($res,JSON_UNESCAPED_UNICODE);
		}

	}

	public function edit()
	{
		// 修改栏目
		$request = Request::instance();
		$category = new CategoryModel();
		if ($request->isPost()) {
			$categoryId = $request->post('id');
			$catename = $request->post('catename');
			$pid = $request->post('pid');

			$res = $category->categoryedit($categoryId,[
				'categoryName' => $catename,
				'pid' => $pid,
			]);
			if($res){
				return json_encode(['code'=>'1','message'=>'修改成功'],JSON_UNESCAPED_UNICODE);
			}else{
				return json_encode(['code'=>'0','message'=>'修改失败'],JSON_UNESCAPED_UNICODE);
			}
			return;
		}
	}
	public function removecategory(){
		// 删除栏目
		$request = Request::instance();
		$category = new CategoryModel();
		if ($request->isPost()) {
			$categoryId = $request->post('removeId');
			$res = $category->categoryremove($categoryId);
			if($res){
				return json_encode(['code'=>'1','message'=>'删除成功'],JSON_UNESCAPED_UNICODE);
			}else{
				return json_encode(['code'=>'0','message'=>'删除失败'],JSON_UNESCAPED_UNICODE);
			}
			return;
		}
	}
}
