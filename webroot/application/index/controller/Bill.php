<?php
namespace app\index\controller;
use think\Controller;
use think\Db;      
use think\Session;
use app\index\model\Customer;
use app\index\model\Note;
use app\index\model\Bill as Bil;

class Bill extends Controller{
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
        $this->assign('titl',Note::GetList($id));
        $this->assign('query',request()->param());
        return $this->fetch();
    }

    function GetNote($id)
    {
        //根据id查询一条数据
        if(empty($id)){
            return $this->error('非法操作!');
        }
        return Note::get($id);
    }

    function FindData(){
        $sql = "select genre,sum(money) as money from note group by genre";
        $result = Db::query($sql);
        return json(['msg'=>$result]);
    }

    function FindData1(){
        $sql1 = "select sum(money) as money from note group by month(add_time)";
        $result1 = Db::query($sql1);
        return json(['msg'=>$result1]);
    }
}