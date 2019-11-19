<?php
namespace app\admin\model;
use think\Model;
class Notice extends Model
{
    static function GetList()
    {
        $key = request()->param('keyword');
        $where = [];
        if(!empty($key)){
            $where['title|content'] = ['like','%'.$key.'%'];
        }
        return Notice::where($where)
                ->order('add_time','desc')
                ->paginate(10,false,['query'=>request()->param()]);
    }
    static function Del($id)
    {
        $rs = 0;
        if(!empty($id)){
            $n = Notice::get($id);
            $rs = $n->delete();
        }
        return $rs;
    }
} 
?>