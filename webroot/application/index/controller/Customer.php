<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\session;
use app\index\model\Customer as Csm;

class Customer extends Controller{

    function GetPwd($pwd = '123')
    {
        //生成一个hash运算后的字符串（md5）摘要
        return md5($pwd);
    }

    public function Login()
    {
        return view();
    }

    function Check()
    {
        //1.接收用户输入的数据（账号、密码、验证码）
        $uid = input('uid');
        $pwd = input('pwd');
        $vrt = input('vrt');
        //2.验证输入的验证码是否正确
        if( captcha_check($vrt) )
        {
            //3.验证账号、密码
            //验证之前先对用户输入的密码进行md5运算
            $pwd = md5($pwd);
            //3.1查找数据库,使用模型类的get方法，传递的是主键
            $list = Csm::get($uid);
            if($uid && $list->pwd == $pwd){
                //登录成功的话，记录seesion，以便验证
                $s = Session::set('curr_uid',$uid);
                return 1;
            }else{
                return 2;
            }
        }
        else
        {
            //验证码错误
            return 0;
        }
    }
    public function Register()
    {
        return view();
    }

    function Add()
    {
        // $rs= input('uid');
        $Csm = new Csm();
        $rs = $Csm->create([
            'uid'=> input('uid'),
            'name'=> input('name'),
            'pwd'=> md5(input('pwd')),
            'sex'=> input('sex'),
            'tel'=> input('tel'),
        ]);
        // dump($rs);
        //添加完成之后完成跳转(重定向)
        if($rs){
            // return 12;
            $this->redirect('/Index/Index/Index');        
        }
    }
}