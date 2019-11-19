<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\WebInfo;
class Webconfig extends Controller
{
    //借助初始化进行权限验证
    //初始化的代码，每次都执行，而且执行在每个代码之前
    //优先执行
    public function _initialize()
    {
        parent::_initialize();
        LevelCheck::isOK("管理员");
    }
    
    function Index()
    {
        $list = WebInfo::all();
        $this->assign('list',$list);
        return view();
    }

    function GetOne()
    {
        if(!empty(input('web_key'))){
            $web = WebInfo::get(input('web_key'));
            return $web;
        }
    }

    function Save()
    {
        if(!empty(input('web_key'))){
            return WebInfo::update($_POST);
        }
    }

    function Server()
    {

    }
}