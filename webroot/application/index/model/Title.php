<?php
namespace app\index\model;
use think\Model;
class Title extends Model
{
    static function GetList()
    {
        $where = [];
        return Title::where($where)
                ->order('add_time','desc')
                ->paginate(4,false,['query'=>request()->param()]);
    }
    static function GetListNews()
    {
        $where = [];
        return Title::where($where)
                ->order('add_time','asc')
                ->paginate(30,false,['query'=>request()->param()]);
    }
}
?>