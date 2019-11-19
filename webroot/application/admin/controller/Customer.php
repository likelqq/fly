<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use app\admin\model\Customer as Cstm;
class Customer extends Controller
{
    // 借助初始化进行权限验证  _initialize()：初始化
    // 初始化的代码，每次都执行，而且执行在每个方法之前
    // 优先执行
    public function _initialize()
    {
        parent::_initialize();
        LevelCheck::isOK('管理员');
    }
    function Index()
    {
         $rq = Request::instance();
         $where = array();
         if(!empty($rq->param('keyword')))
         {
             $where['name'] = ['like','%'.$rq->param('keyword').'%'];
         }
         //查询所有员工数据，传递给模板页
         $list = Cstm::where($where)
                     ->order('uid','asc')
                     ->paginate(15,false,['query'=>request()->param()]);
         //利用assign()方法向页面传值
         $this->assign('list',$list);
         //往前台回传搜索的参数，如keyword等
         $this->assign('query',request()->param());
         return $this->fetch(); 
    }
    function Login()
    {

    }
    function data(){
        $n = Cstm::all();//get是模型的
        // dump($n);
        $data = $n[0];
        // return $data;
        return json(['data'=>$data]);
        // $path = $n[0]['path'];
        // $path = $n[0]['path'];
    }
}
?>