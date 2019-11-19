<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\controller\LevelCheck;
use app\admin\model\Title as Tie;
class Title Extends Controller
{
    //借助初始化进行权限验证
    //初始化的代码，每次都执行，而且执行在每个代码之前
    //优先执行
    public function _initialize()
    {
        parent::_initialize();
        LevelCheck::isOK("编辑");
    }
    
    function Index(){
        // $m = new Tie();
        // $this->assign('list',$m->GetList());
        $this->assign('list',Tie::GetList());
        $this->assign('query',request()->param());
        return view();
    }

    function Del($id)
    {
        $a = Tie::get($id);
        $rs = $a->delete();
        if($rs){
            //当删除数据时，需要同时删除图片，以免产生图片遗留
            $this->DelPic($a->path);
            $this->redirect('Index');
        }else{
            $this->error('删除失败！');
        }
    }

    function DelAll(){
        $ids = input('ids');
        $tieList = Tie::all($ids);
        foreach($tieList as $a){
            $this->DelPic($a->path);
        }
        $rs = Tie::destroy($ids);
        return $rs;
    }

    function GetTie($id){
        $a = Tie::get($id);
        return $a;
    }

    //用于删除废弃的图像
    function DelPic($pic){
        $file = ROOT_PATH.'/public/'.$pic;
        //先进行存在性判断（防止删除失败/防止空删除）
        if(file_exists($file)){
            //则可以删除
            unlink($file);
        }
    }

    function Add(){
        return view();
    }

    function AddSave()
    {
        // 数据添加到数据库
        $rs = Tie::insert($_POST);
        if($rs){
            $this->redirect('Index');
        }
    }

    function Edit($id){
        if(!empty($id)){//empty是php自带的
            $n = Tie::get($id);//get是模型的
            $this->assign('tie',$n);
            return view('Modify');
        }else{
            $this->error('非法操作！');//error继承controller的，官方写的，打开think目录下查找
        }
    }

    function data(){
        $n = Tie::all();//get是模型的
        // dump($n);
        $data = $n[0];
        // return $data;
        return json(['data'=>$data]);
        // $path = $n[0]['path'];
        // $path = $n[0]['path'];
    }

    function EditSave(){
        $n = Tie::get(input('id'));
        $n->title = input('title');
        $n->author = input('author');
        $n->add_time = input('add_time');
        $n->content = input('content');
        $rs = $n->save();
        if($rs){
            $this->redirect('Index');
        }else{
            $this->error('修改失败！');
        }
    }
}