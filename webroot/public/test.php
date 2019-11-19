<?php
//设置页面可以跨域
header("Access-Control-Allow-Origin:*");//* 都开放
// $name = $_GET['name'];
$name = $_REQUEST['name'];//可以接受GET方法，也可以接受POST方法
echo "服务端数据:".$name;
?>