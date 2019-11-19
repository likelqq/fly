<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use app\admin\model\Employee as Emp;

Class Index extends Controller
{
    //该方法用于打开管理员的首页
    function Index()
    {
        $id = Session::get('curr_uid');
        // var_dump($id);
        $list = Emp::where('id',$id)
                    ->paginate(3);
        //利用assign()方法向页面传值
        $this->assign('list',$list);
        return $this->fetch();
    }

    //仅仅是用来显示欢迎标语，没有实际意义
    function Welcome()
    {
        return view();
    }
}
?>