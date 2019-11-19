<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Notice as Ntc;
class Notice extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        LevelCheck::isOK("编辑");
    }
    function Index()
    {
        $this->assign('list',Ntc::GetList());
        $this->assign('query',request()->param());
        return view();
    }
    function Del($id)
    {
        if (Ntc::Del($id)==0){
            return $this->error('删除失败！');
        }else{
            return $this->redirect('Index');
        }
    }

    function DelAll()
    {
        $ids = input('ids');
        $rs = Ntc::destroy($ids);
        return $rs;
    }
    function Add()
    {
        return view();
    }
    
    function AddSave()
    {
        // 数据添加到数据库
        $rs = Ntc::insert($_POST);
        if($rs){
            $this->redirect('Index');
        }
    }

    // 修改
    function Edit($id)
    {
        // empty PHP自带的语法
        if(!empty($id)){
            // get model类里面自带的
            $n = Ntc::get($id);
            $this->assign('notice',$n);
            return view('Modify');
        }else{
            // error继承Controller，官方写的，打开thinkphp文件夹
            $this->error('非法操作！');
        }
    }
    function EditSave()
    {
        $n = Ntc::get(input('id'));
        $n->title = input('title');
        $n->add_time = input('add_time');
        $n->content = input('content');
        $rs = $n->save();
        if($rs){
            $this->redirect('Index');
        }else{
            $this->error('修改失败！');
        }
    }

    // function data(){
    //     $n = Ntc::all();//get是模型的
    //     // dump($n);
    //     $data = $n[0];
    //     // return $data;
    //     return json(['data'=>$data]);
    //     // $path = $n[0]['path'];
    //     // $path = $n[0]['path'];
    // }
}
?>