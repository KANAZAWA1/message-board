<?php
session_start();
header("Content-type: text/html; charset=utf-8");
include("./moban/changepasswd.html");
include("./DB.php");

$oldpasswd = $_POST['oldpasswd'];
$newpasswd = $_POST['newpasswd'];
$user = $_SESSION['username'];

if(isset($_POST['submit']) && isset($_SESSION['uid'])){
    if(empty($oldpasswd) || empty($newpasswd)){
        die('修改内容不能为空！');
    }
    
    $check_list = "/into|load_file|0x|outfile|by|substr|base|echo|hex|mid|like|or|char|union|or|select|greatest|%00|\'|KANAZAWA|limit|=_| |in|<|>|-|user|\.|\(\)|#|and|if|database|where|concat|insert|having|sleep|hex2bin|chr/i";
    $checks = ["$oldpasswd", "$newpasswd"];
    foreach($checks as $check){ ##此处再再膜拜Virink师傅那次的正则小考核，提供的思路
        $m = preg_match($check_list, $check);
        if($m){
            die("stop hacking!");
        }
    }

    mysqli_select_db($link, 'message~board');
    $sql = "select * from user where password = '$oldpasswd'";
    $res = mysqli_query($link, $sql);
    $row = mysqli_num_rows($res);
    if($row > 0){
        $sql1 = "update user set password='$newpasswd' where username='$user'";
        $res1 = mysqli_query($link, $sql1);
        if($res1){
            echo "<script>alert('修改成功！')</script>"."<meta http-equiv='Refresh'content='0;url=./loginout.php'/>";
        }else{
            die('数据库异常，请稍后再试！');
        }
    }else{
        die("您的旧密码有误！");
    }
    mysqli_close($link);
}
?>