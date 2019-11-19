<?php
namespace app\admin\model;
use think\Model;
class Employee extends Model
{
    //指定附表从属关系
    function actor()
    {
        return $this->belongsTo(
            'Actor',
            'actor_id',
            'id'
        )->field('id,name');
    }
}
?>