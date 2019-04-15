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
		// return json_encode($res,JSON_UNESCAPED_UNICODE);
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
		// 查看文章
		$articleId = input('id');
		$article = new ArticleModel();
		$data = $article->articleFind(['id'=>$articleId]);	//链接数据库
		$imgUrl = db('thumb')->where('pid',$data['id'])->find();

		$this->assign('data', $data);
		$this->assign('imgUrl', $imgUrl);
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
				'click' => 0,
				'zan' => 0,
				'time' => date('Y-n-j H:i:s'),
				'cateId' => input('post.cateId'),
			];
			$res = $article->articleAdd($data);
			if(input('post.imgId')){
				$imgId = input('post.imgId');
				db('thumb')->where(['id'=>$imgId])->update(['pid' => $res]);
			}
			// return json_encode($res,JSON_UNESCAPED_UNICODE);
			if($res){
				return json_encode(['code'=>'1','message'=>'添加成功'],JSON_UNESCAPED_UNICODE);
			}else{
				return json_encode(['code'=>'0','message'=>'添加失败'],JSON_UNESCAPED_UNICODE);
			}
		}
	}
	public function uploadimg()
	{
		$files = request()->file('thumb');
		if(input('pid')){
			$pid = input('pid');
		}else{
			$pid = '';
		}
		db('thumb')->where(['pid'=>$pid])->delete();	// 上传覆盖
		foreach($files as $file){
      // 移动到框架应用根目录/public/uploads/ 目录下
      $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
      if($info){
        // 成功上传后 获取上传信息
        $getSaveName=str_replace("\\","/",$info->getSaveName());
        $thumb = '/uploads/' . $getSaveName;
      }
    }
		$res = db('thumb')->insertGetId(['url'=>$thumb,'pid'=>$pid]);
		$resp = db('thumb')->where(['id'=>$res])->find();
		if($res){
			$thumbId = $resp['id'];
			$thumbUrl = $resp['url'];
			return json_encode(['code'=>'1','message'=>'上传成功','thumbId'=>$thumbId,'thumbUrl'=>$thumbUrl],JSON_UNESCAPED_UNICODE);
		}else{
			return json_encode(['code'=>'0','message'=>'上传失败'],JSON_UNESCAPED_UNICODE);
		}
	}
	public function deleteimg()
	{
		$delId = input('post.delId');
		$res = db('thumb')->where('id',$delId)->delete();
		if($res){
			return json_encode(['code'=>'1','message'=>'删除成功'],JSON_UNESCAPED_UNICODE);
		}else{
			return json_encode(['code'=>'0','message'=>'删除失败'],JSON_UNESCAPED_UNICODE);
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
		// 获取栏目列表
		$category = new CategoryModel();
		$res = $category->catetree();
		$this->assign('categoryres',$res);
		// 获取文章内容
		$request = Request::instance();
		$article = new ArticleModel();
		$articleres = $article->articleFind(['id'=>input('id')]);
		$this->assign('articleres',$articleres);

		// 获取图片内容
		$imageres = db('thumb')->where(['pid'=>input('id')])->find();
		$this->assign('imageres',$imageres);

		return view();

	}
	public function editarticle()
	{
		// 修改文章
		$request = Request::instance();
		$article = new ArticleModel();
		if ($request->isPost()) {
			$cateId = $request->post('cateId');
			$articleId = $request->post('articleId');
			$title = $request->post('title');
			$auther = $request->post('auther');
			$keywords = $request->post('keywords');
			$des = $request->post('des');
			$content = $request->post('content');

			$data = [
				'cateId' => $cateId,
				'title' => $title,
				'auther' => $auther,
				'keywords' => $keywords,
				'des' => $des,
				'content' => $content,
			];

			$res = $article->articleedit($articleId,$data);
			if($res){
				return json_encode(['code'=>'1','message'=>'修改成功'],JSON_UNESCAPED_UNICODE);
			}else{
				return json_encode(['code'=>'0','message'=>'修改失败'],JSON_UNESCAPED_UNICODE);
			}
			return;
		}
	}
	public function removearticle()
	{
		// 删除文章
		$request = Request::instance();
		$article = new ArticleModel();
		if ($request->isPost()) {
			$articleId = $request->post('removeId');
			$res = $article->articleremove($articleId);
			db('thumb')->where('pid',$articleId)->delete();
			if($res){
				return json_encode(['code'=>'1','message'=>'删除成功'],JSON_UNESCAPED_UNICODE);
			}else{
				return json_encode(['code'=>'0','message'=>'删除失败'],JSON_UNESCAPED_UNICODE);
			}
			return;
		}
	}
}
