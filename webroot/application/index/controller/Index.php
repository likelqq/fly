<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use app\index\model\Customer;
use app\index\model\Note;
use app\index\model\Into;

class Index extends Controller
{
    function Index()
    {
        $id = Session::get('curr_uid');
        $list = Customer::where('uid',$id)->field('uid')->find();
        $this->assign('uid',$list['uid']);
        $this->assign('list',$list);
        $this->assign('titl',Note::GetList($id));
        $this->assign('into',Into::GetList($id));
        $this->assign('query',request()->param());
        return $this->fetch();
    }

    function Logout()
    {
        Session::delete('curr_uid');
        $this->redirect('/Index/Index/Index');
    }

    function GetNote($id)
    {
        //根据id查询一条数据
        if(empty($id)){
            return $this->error('非法操作!');
        }
        return Note::get($id);
    }

    function GetInto($id)
    {
        if(empty($id)){
            return $this->error('非法操作!');
        }
        return Into::get($id);
    }

    function AddSave()
    {
        if(Session::get('curr_uid')){
            $id=Session::get('curr_uid');
            $not = new Note();
            $rs = $not->create([
            'money'=> input('money'),
            'genre'=> input('genre'),
            'customer_uid'=> $id,
            ]);
            if($rs){
                $this->redirect('Index');
            }
        }
        else{
            $this->redirect('/Index/Index/Index');
        }
    }

    function EditSave()
    {
        //修改
        $data = $_POST['data'];
        $data = json_decode($data,true);
        $id = $data['id'];
        $genre = $data['genre'];
        $money = $data['money'];
        $not = Note::get($id);
        $not->money=$money;
        $rs = $not->save();
        if($rs){
            return json(['state'=>'1','msg'=>'修改成功!']);
        }else{
            return json(['state'=>'0','msg'=>'修改失败!']);
        }
    }

    // 删除一个对象
    function Del()
    {
        $id = input('id');
        $e = Note::get($id);
        $rs = $e->delete();
        return $id;
    }

    //收入
    function Add()
    {
        if(Session::get('curr_uid')){
            $id=Session::get('curr_uid');
            $in = new Into();
            $rs = $in->create([
            'money'=> input('money'),
            'genre'=> input('genre'),
            'customer_uid'=> $id,
            ]);
            if($rs){
                $this->redirect('Index');
            }
        }
        else{
            $this->redirect('/Index/Index/Index');
        }
    }

    function Edit()
    {
        $data = $_POST['data'];
        $data = json_decode($data,true);
        $id = $data['id'];
        $genre = $data['genre'];
        $money = $data['money'];
        $ins = Into::get($id);
        $ins->money=$money;
        $rs = $ins->save();
        if($rs){
            return json(['state'=>'1','msg'=>'修改成功!']);
        }else{
            return json(['state'=>'0','msg'=>'修改失败!']);
        }
    }

    // 删除一个对象
    function Dell()
    {
        $id = input('id');
        $e = Into::get($id);
        $rs = $e->delete();
        return $rs;
    }
}
