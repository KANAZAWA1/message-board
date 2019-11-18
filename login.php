<?php
session_start();
header("Content-type: text/html; charset=utf-8");
include("./moban/login.html");
include("./DB.php");

$user = $_POST['username'];
$pass = $_POST['password'];

if(isset($_POST['submit'])){
    if(empty($user) || empty($pass)){
        die('账户或密码不能为空，请重新登录！');
    }

    $check_list = "/into|load_file|0x|outfile|by|substr|base|echo|hex|mid|like|or|char|union|or|select|greatest|%00|\'|KANAZAWA|limit|=_| |in|<|>|-|user|\.|\(\)|#|and|if|database|where|concat|insert|having|sleep|hex2bin|chr/i";
    $checks = ["$user", "$pass"];
    foreach($checks as $check){ ##此处再膜拜Virink师傅那次的正则小考核，提供的思路，我要做VK师傅的第一舔狗
        $m = preg_match($check_list, $check);
        if($m){
            die("$check-SQL injection?");
        }
    }
    
    if(!$link){
        die('数据库连接失败: " . mysqli_connect_error()');
    }else{
        mysqli_select_db($link, 'message~board');
        $sql = "select * from user where username = '$user' and password = '$pass'";
        $res = mysqli_query($link, $sql);
        $row = mysqli_num_rows($res);
        if($row > 0){
            $person = mysqli_fetch_array($res);
            $_SESSION['username'] = $user;
            $_SESSION['uid'] = md5('VKVKVKVKVKVKVKVK');
            echo "登录成功，PS：请不要禁用JS";
            echo "<script>window.location.href=\"action.php\"</script>";
        }else{
            die('账户或密码错误，请重新登陆！');
        }
    }
    mysqli_close($conn);
}
?>