<?php
namespace app\index\model;
use think\Model;
class Notice extends Model
{
    static function GetList()
    {
        $where = [];
        return Notice::where($where)
                ->order('add_time','desc')
                ->paginate(5,false,['query'=>request()->param()]);
    }
}
?>