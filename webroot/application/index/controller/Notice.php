<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use app\index\model\Customer;
use app\index\model\Notice as Ntc;

class Notice extends Controller
{
    public function _initialize()
    {
        if(Session::get('curr_uid')){

        }
        else{
            $this->redirect('/Index/Customer/Login');
        }
    }
    
    function Index()
    {
        //获取当前的id
        $id = Session::get('curr_uid');
        $list = Customer::where('uid',$id)->field('uid')->find();
        $this->assign('uid',$list['uid']);
        $this->assign('list',Ntc::GetList());
        return $this->fetch();
    }

    function GetNotice($id)
    {
        //根据id查询一条数据
        if(empty($id)){
            return $this->error('非法操作!');
        }
        return Ntc::get($id);
    }
}