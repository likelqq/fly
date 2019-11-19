<?php
namespace app\admin\controller;
use think\Controller;
//引用验证码的操作类(导入包/引入空间)
// use think\captcha\Captcha;
//因为模型类和控制器类重名，所以定义了一个别名
use app\admin\model\Actor as Act;
class Actor extends Controller
{
    // 借助初始化进行权限验证
    // 初始化的代码，每次都执行，而且执行在每个代码之前
    // 优先执行
    public function _initialize()
    {
        parent::_initialize();
        LevelCheck::isOK("管理员");
    }

    //显示员工管理界面（附带数据）
    function Index()
    {
       
        //连接数据库
       
       // 1.接收用户搜索的关键字
        //查询所以员工数据，传递给模板页
        $list = Act::all();
        //利用assign()方法向页面传值
        $this->assign('list',$list);
        return $this->fetch();
    }

    function GetActor($id)
    {
        //根据id查询一条数据
        if(empty($id)){
            return $this->error('非法操作!');
        }
        return Act::get($id);
    }
    //完成添加修改两个功能
    function SaveActor()
    {
        $id = input('id');
        $name = input('name');
        //表示添加
        $actor = new Act();
        //表示修改
        if(!empty($id)){
            $actor = Act::get($id);
        }
        $actor->id=$id;
        $actor->name=$name;
        return $actor->save();
    }
    //显示'添加页面'
    // function Add()
    // {
    //     //需要把角色数据传给页面
    //     //查数据库
    //     $this->assign('actor',Act::all() );
    //     return $this->fetch();
    // }

    // //用来处理添加员工数据(当用户点击提交的时候处理)
    // function AddSave()
    // {
    //     $act = new Act();
    //     $rs = $act->create([
    //         'name'=> input('name'),
    //     ]);
    //     //添加完成之后完成跳转(重定向)
    //     if($rs){
    //         $this->redirect('List');
    //     }
    // }

    // 删除一个对象
    function Del($id)
    {
        // 先到数据库查询该对象
        $e = Act::get($id);
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
        $ids = input('ids');
        $rs = Act::destroy($ids);
        return $rs;
    }

    //打开修改界面
    function Edit($id)
    {
        //先查询“角色”数据，返回页面，供下拉框选择使用
       // $this->assign("actor",Actor::all());
        $this->assign("act",Act::get($id));
        return $this->fetch();
    }
}
?>