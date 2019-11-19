<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use app\index\model\Customer;
use app\index\model\Title as Ns;

class Title extends Controller
{
    function Index()
    {
        //获取当前的id
        $id = Session::get('curr_uid');
        $list = Customer::where('uid',$id)->field('uid')->find();
        $this->assign('uid',$list['uid']);
        $this->assign('list',Ns::GetList());
        $this->assign('listnew',Ns::GetListNews());
        return $this->fetch();
    }

    function GetNews($id)
    {
        $ids = Session::get('curr_uid');
        $list = Customer::where('uid',$ids)->field('uid')->find();
        $this->assign('uid',$list['uid']);
        //根据id查询一条数据
        if(empty($id)){
            return $this->error('非法操作!');
        }
        $this->assign('new',Ns::get($id));
        // return $new;
        return $this->fetch('Open');
    }
}
