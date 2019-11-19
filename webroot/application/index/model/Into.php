<?php
namespace app\index\model;
use think\Model;
class Into extends Model
{
    static function GetList($id)
    {
        return Into::where("customer_uid",$id)
                ->order('add_time','desc')
                ->paginate(5,false,['query'=>request()->param()]);
    }
}
?>