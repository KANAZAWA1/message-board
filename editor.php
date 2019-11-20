<?php
session_start();
header("Content-type: text/html; charset=utf-8");
include("./moban/editor.html");
include("./DB.php");

$id = $_GET['id'];
$text = $_POST['text'];
if(isset($_POST['submit'])){
    if(empty($text)){
        die('修改内容不能为空，请重新修改！');
    }

    $check_list = "/into|load_file|0x|outfile|by|substr|base|echo|hex|mid|like|or|char|union|or|select|greatest|%00|\'|KANAZAWA|limit|=_| |in|<|>|-|user|\.|\(\)|#|and|if|database|where|concat|insert|having|sleep|hex2bin|chr/i";
    $m = preg_match($check_list, $text);
    if($m){
        die('stop hacking!');
    }

    mysqli_select_db($link, 'message~board');
    $sql = "select * from message where Id = '$id'";
    $res = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($res);
    echo $row;
    if($row['username'] !== $_SESSION['username']){
        die("您无法修改他人留言！"."<meta http-equiv='Refresh'content='3;url=./index.php'/>");
    }

    $sql1 = "update message set text='$text' where Id='$id'";
    $res1 = mysqli_query($link, $sql1);

    if($res1){
        echo "修改成功，请返回查看！";
    }else{
        die('数据库异常，请稍后再试！');
    }
    
    mysqli_close($link);
}
?>