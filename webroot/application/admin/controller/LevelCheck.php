<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use app\admin\model\Employee as Emp;
class LevelCheck extends Controller
{
    static function isOK($level)
    {
        // 判断是否登录，如果未登录，则返回登录界面
        if(!Session::get('curr_uid'))
        {
            echo "<script>alert('抱歉，您没有登录或登录超时！');top.location.href='/admin/Employee/login';</script>";
        }
        // 如果已经登录，则查看其属于什么角色
        $e = Emp::get(Session::get('curr_uid'));
        // 判断当前角色是否符合权限要求
        if($e->actor->name != $level)
        {
            echo "<script>alert('抱歉，您没有登录的操作权限！');history.back();</script>";
        }
    }
}
?>