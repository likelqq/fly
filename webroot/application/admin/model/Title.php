<?php
namespace app\admin\model;
use think\Model;
class Title extends Model
{
    //几乎不需要写代码，完全继承了Model
    //也就是已经具备了增删改查的所有操作
    // function static GetList(){
    static function GetList(){
        $key = request()->param('keyword');
        $where = [];
        if(!empty($key)){
            $where['title|content'] = ['like','%'.$key.'%'];
        }
        return Title::where($where)
                    ->order('add_time','desc')
                    ->paginate(10,false,['query'=>request()->param()]);
    }

    static function Del($id){
        if(!empty($id)){
            $n = Title::get($id);
            $rs = $n->delete();
        }
        return $rs;
    }
}
?>