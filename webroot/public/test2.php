<?php
    header("Access-Control-Allow-Origin:*");//* 都开放
    // $book = array("name"=>"PHP程序设计","price"=>20);
    // $b = json_encode($book);//解码
    // echo $b;

    //PHP数组
    $bookList = array(
        ['name'=>'PHP程序设计','price'=>20],
        ['name'=>'JavaWeb','price'=>30],
        ['name'=>'C#程序设计','price'=>50]
    );
    //使用PHP的json_encode对数组进行json编码，以便输出和传递
    // echo json_encode( $bookList);

    //接收从客户端传来的json数据，以便存储的数据库
    $book = $_REQUEST["book"];
    //对接收到的数据进行解码，以便存储和操作
    $b = json_decode($book);
    //操作举例
    echo $b->name."是提交来的";
?>