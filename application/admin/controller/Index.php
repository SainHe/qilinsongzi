<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
class Index extends Controller
{
    public function index($name = '张三', $sex='女')
    {
		//$data = Db::name('user')->find();	//链接数据库
		//print_r($data);
		/*$this->assign('data', $data);
		
		$this->assign('sex', $sex);*/
		//return $this->fetch();

		//print_r($this->request->param());

        //echo "hello: ".$name ." ".$sex;      
		$request = Request::instance();
// 获取当前域名
echo 'domain: ' . $request->domain() . '<br/>';
// 获取当前入口文件
echo 'file: ' . $request->baseFile() . '<br/>';
// 获取当前URL地址 不含域名
echo 'url: ' . $request->url() . '<br/>';
// 获取包含域名的完整URL地址
echo 'url with domain: ' . $request->url(true) . '<br/>';
// 获取当前URL地址 不含QUERY_STRING
echo 'url without query: ' . $request->baseUrl() . '<br/>';
// 获取URL访问的ROOT地址
echo 'root:' . $request->root() . '<br/>';
// 获取URL访问的ROOT地址
echo 'root with domain: ' . $request->root(true) . '<br/>';
// 获取URL地址中的PATH_INFO信息
echo 'pathinfo: ' . $request->pathinfo() . '<br/>';
// 获取URL地址中的PATH_INFO信息 不含后缀
echo 'pathinfo: ' . $request->path() . '<br/>';
// 获取URL地址中的后缀信息
echo 'ext: ' . $request->ext() . '<br/>';
		//$data = Db::name('user')->find();
		//print_r($data['UserName']);
		/*$result=array(  
              'code'=>111,  
              'msg'=>222, 
			  'count'=>333,  
              'data'=>444  
            );  
            //输出json  
            echo json_encode($result);  
            exit;  */
			
			
    }
	public function login()
	{
		echo '1';
		if (Request::instance()->isPost()) return "当前为 POST 请求";
		//$data = Db::name('user')->find();
		//print_r($data);
	}
}
