<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Session;
//引用验证码的操作类(导入包/引入空间)
// use think\captcha\Captcha;
//因为模型类和控制器类重名，所以定义了一个别名
use app\admin\model\Employee as Emp;
use app\admin\model\Actor;

class Employee extends Controller
{
    //借助初始化进行权限验证
    //初始化的代码，每次都执行，而且执行在每个代码之前
    //优先执行
    // public function _initialize()
    // {
    //     parent::_initialize();
    //     LevelCheck::isOK("管理员");
    // }

    function GetPwd($pwd = '123')
    {
        //生成一个hash运算后的字符串（md5）摘要
        return md5($pwd);
    }

    function Logout()
    {
        //使用原生php的卸载
        // unset($_SESSION['curr_uid']);
        //使用thinkphp的代码
        // session("curr_uid",NULL);
        //退出清空session
        session(null);
        $this->redirect("/Admin/Employee/Login");
    }

    public function Login()
    {
        //到view下面的Employee文件夹下找login.html
        return view();
    }

    //负责验证用户输入的账号信息
    function Check()
    {
        //1.接收用户输入的数据（账号、密码、验证码）
        // $uid = $_POST['uid'];
        // $pwd = $_POST['pwd'];
        // $vrt = $_POST['vrt'];
        $uid = input('uid');
        $pwd = input('pwd');
        $vrt = input('vrt');
        // return '输入的账号：'.$uid;

        //2.验证输入的验证码是否正确
        //实例化‘验证码类’
        // $ck = new Captcha();
        //调用验证码类的check()方法进行验证
        // if( $ck->check($vrt) )
        //如果使用captcha_check($vrt)，就可以不引用captcha类，同时也不需要实例化captcha类，而是直接调用以节省代码
        if( !captcha_check($vrt) )
        {
            return 0;
            // return "验证码正确！";
        }
        // else
        // {
        //     return "验证码错误！";
        //     // return "<script>alert('验证码错误！');history.back();</script>";
        // }

        //3.验证账号、密码
        //验证之前先对用户输入的密码进行md5运算
        $pwd = md5($pwd);
        //3.1查找数据库,使用模型类的get方法，传递的是主键
        $admin = Emp::get($uid);
        if($admin && $admin->pwd == $pwd){
            //登录成功的话，记录seesion，以便验证
            $s = Session::set('curr_uid',$uid);
            return 1;
        }else{
            return 2;
        }
    }

    //显示员工管理界面（附带数据）
    function Index()
    {
        LevelCheck::isOK("管理员");
        //1.接收用户搜索的关键字
        $rq = Request::instance();
        $where = array();
        if(!empty($rq->param('keyword')))
        {
            $where['name'] = ['like','%'.$rq->param('keyword').'%'];
        }
        //查询所以员工数据，传递给模板页
        $list = Emp::where($where)
                    ->order('id','asc')
                    ->paginate(3,false,['query'=>request()->param()]);
        //利用assign()方法向页面传值
        $this->assign('list',$list);
        //往前台回传搜索的参数，如keyword等
        $this->assign('query',request()->param());
        return $this->fetch();
    }

    //显示'添加页面'
    function Add()
    {
        LevelCheck::isOK("管理员");
        //需要把角色数据传给页面
        //查数据库
        $this->assign('actor',Actor::all() );
        return $this->fetch();
    }

    //用来处理添加员工数据(当用户点击提交的时候处理)
    function AddSave()
    {
        LevelCheck::isOK("管理员");
        //1.使用save
        //实例化一个员工对象
        // $emp = new Emp();
        //给员工对象赋值
        // $emp->name = input('name');
        // $emp->id = input('id');
        // $emp->pwd = md5(input('pwd'));
        // $emp->tel = input('tel');
        // $emp->sex = input('sex');
        // $emp->actor_id = input('actor');
        //执行保存（数据库）
        // $rs = $emp->save();

        //2.使用create
        $emp = new Emp();
        $rs = $emp->create([
            'name'=> input('name'),
            'id'=> input('id'),
            'pwd'=> md5(input('pwd')),
            'sex'=> input('sex'),
            'tel'=> input('tel'),
            'actor_id'=> input('actor'),
        ]);
        //添加完成之后完成跳转(重定向)
        if($rs){
            $this->redirect('Index');
        }
    }

    // 删除一个对象
    function Del($id)
    {
        LevelCheck::isOK("管理员");
        // 先到数据库查询该对象
        $e = Emp::get($id);
        // 然后删除
        $rs = $e->delete();
        // 判断是否删除
        if($rs){
            $this->redirect('Index');
        }
    }

    //批量删除
    function DelAll()
    {
        LevelCheck::isOK("管理员");
        $ids = input('ids');
        $rs = Emp::destroy($ids);
        return $rs;
    }

    //打开修改界面
    function Edit($id)
    {
        LevelCheck::isOK("管理员");
        //先查询“角色”数据，返回页面，供下拉框选择使用
        $this->assign("actor",Actor::all());
        $this->assign("emp",Emp::get($id));
        return $this->fetch();
    }

   
    //用来保存修改操作
    function ModifySave()
    {
        LevelCheck::isOK("管理员");
        //1.先查询
        $emp = Emp::get(input('id'));
        //2.修改相关属性
        $emp->name = input('name');
        $emp->sex = input('sex');
        $emp->tel = input('tel');
        $emp->actor_id = input('actor');
        //3.提交更改后的数据
        $rs = $emp->save();
        // return $rs;
        if($rs){
            $this->redirect('Index');
        }else{
            return "<script>alert('修改无效！');history.back(-1);</script>";
        }
    }
}
?>