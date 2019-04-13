<?php
namespace app\admin\controller;
use think\Request;
use app\admin\model\Article as ArticleModel;
use app\admin\model\Category as CategoryModel;
use app\admin\controller\Common;
class Article extends Common
{
	public function index()
	{
		// 文章列表
		$article = new ArticleModel();
		$res = $article->articleget();
		$this->assign('articleres',$res);
		return view();
	}
	public function add()
	{
		// 添加文章页面
		$category = new CategoryModel();
		$res = $category->catetree();
		$this->assign('categoryres',$res);
		return view();
	}
	public function show()
	{
		$articleId = input('id');
		$article = new ArticleModel();
		$data = $article->articleFind(['id'=>$articleId]);	//链接数据库
		$this->assign('data', $data);
		return view();
	}
	public function addarticle()
	{
		// 添加文章请求方法
		$request = Request::instance();
		$article = new ArticleModel();
		if ($request->isPost()) {
			$data = [
				'title' => input('post.title'),
	      'keywords' => input('post.keywords'),
	      'des' => input('post.des'),
	      'auther' => input('post.auther'),
	      'content' => input('post.content'),
	      'thumb' => input('post.thumb'),
				'click' => 0,
				'zan' => 0,
				'time' => date('Y-n-j H:i:s'),
				'cateId' => input('post.cateId'),
			];
			$res = $article->articleAdd($data);
			// return json_encode($res,JSON_UNESCAPED_UNICODE);
			if($res){
				return json_encode(['code'=>'1','message'=>'添加成功'],JSON_UNESCAPED_UNICODE);
			}else{
				return json_encode(['code'=>'0','message'=>'添加失败'],JSON_UNESCAPED_UNICODE);
			}
		}
	}

	public function findarticle()
	{
		// 根据传入ID查询单条数据
		$request = Request::instance();
		$article = new ArticleModel();
		if ($request->isPost()) {
			$articleId = $request->post('id');
			$res = $article->articleFind(['id'=>$articleId]);
			return json_encode($res,JSON_UNESCAPED_UNICODE);
		}

	}

	public function edit()
	{
		// 修改留言
		$request = Request::instance();
		$article = new ArticleModel();
		if ($request->isPost()) {
			$articleId = $request->post('id');
			$contacts = $request->post('contacts');
			$phone = $request->post('phone');
			$email = $request->post('email');
			$weixin = $request->post('weixin');
			$leaveContent = $request->post('leaveContent');


			$res = $article->articleedit($articleId,[
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
	public function removearticle(){
		// 删除留言
		$request = Request::instance();
		$article = new ArticleModel();
		if ($request->isPost()) {
			$articleId = $request->post('removeId');
			$res = $article->articleremove($articleId);
			if($res){
				return json_encode(['code'=>'1','message'=>'删除成功'],JSON_UNESCAPED_UNICODE);
			}else{
				return json_encode(['code'=>'0','message'=>'删除失败'],JSON_UNESCAPED_UNICODE);
			}
			return;
		}
	}
}
