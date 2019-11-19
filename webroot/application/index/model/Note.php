<?php
namespace app\index\model;
use think\Model;
class Note extends Model
{
    static function GetList($id)
    {
        return Note::where("customer_uid",$id)
                ->order('add_time','desc')
                ->paginate(5,false,['query'=>request()->param()]);
    }
}
?>