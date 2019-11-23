<?php
session_start();
header("Content-type: text/html; charset=utf-8");
include("./moban/write.html");
include("./DB.php");

$text = $_POST['text'];

if(isset($_POST['submit'])){
    if(empty($text)){
        die('发布的新留言不能为空！');
    }

    $check_list = "/into|load_file|0x|outfile|by|substr|base|echo|hex|mid|like|or|char|union|or|select|greatest|%00|\'|KANAZAWA|limit|=_| |in|<|>|-|user|\.|\(\)|#|and|if|database|where|concat|insert|having|sleep|hex2bin|chr/i";
    $m = preg_match($check_list, $text);
    if($m){
        die('stop hacking!');
    }

    mysqli_select_db($link, 'message~board');
    $user = $_SESSION['username'];
    $time = date('Y-m-d');
    $sql = "insert into message(username, text, time) values('$user', '$text', '$time')";
    $res = mysqli_query($link, $sql);
    if($res){
        echo "<script>alert('发布成功！')</script>"."<meta http-equiv='Refresh'content='0;url=./index.php'/>";
    }else{
        die('数据库异常，请稍后再试！');
    }

    mysqli_close($link);
}
?>