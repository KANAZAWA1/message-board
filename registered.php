<?php
header("Content-type: text/html; charset=utf-8");
include("./moban/registered.html");
$user = $_POST['username'];
$pass = $_POST['password'];
$res_pass = $_POST['res_password'];
$phone = $_POST['phone'];
$email = $_POST['email'];

if(isset($_POST['submit'])){  #输入不能为空
    if(empty($user) || empty($pass) || empty($res_pass) || empty($phone) || empty($email)){
        die('必填项不能为空，请重新注册！');
    }elseif($pass !== $res_pass){
        die('两次密码必须一致，请重新注册！');
    }elseif(!preg_match('/^\w+$/i', $user)){
        die('用户名不合法,请重新注册！');
    }elseif(!preg_match('/^[\w\.]+@\w+\.\w+$/i', $email)){
        die('邮箱不合法，请重新注册！');
    }elseif(!preg_match('/^1\d{10}$/i', $phone)){
        die('手机不合法，请重新注册');
    }

    $check_list = "/into|load_file|0x|outfile|by|substr|base|echo|hex|mid|like|or|char|union|or|select|greatest|%00|\'|KANAZAWA|limit|=_| |in|<|>|-|user|\.|\(\)|#|and|if|database|where|concat|insert|having|sleep|hex2bin|chr/i";
    $checks = ["$user", "$pass", "$res_pass", "$phone"];
    foreach($checks as $check){ ##此处膜拜Virink师傅那次的正则小考核，提供的思路
        $m = preg_match($check_list, $check);
        if($m){
            die("$check-SQL injection?");
        }
    }
    /*Virink师傅小考核给的思路
    <?php
        $emails = [
	'   virink@outlook.com',
	    'virink@test.outlook.com',
	    'my email is virink@test.orz.outlook.com',
	    'do you know virink-orz@test.a-b.com?',
	    'send to virink.orz@test.orz.outlook.com is very good!',
        ];

        foreach ($emails as $email) {
	        preg_match('/([\w\-\.]+)@/', $email, $m) && print_r($m[1] . "\n");
            preg_match('/([\w\-\.]+)@[\w\-]+(\.[\w\-]+)+/', $email, $m) && print_r($m[1] . "\n");*/
    
    $dbservername = "localhost";
    $dbusername = "root";
    $dbpassword = "123456";
    //创建连接
    $link = mysqli_connect($dbservername, $dbusername, $dbpassword);
    if(!$link){
        die('数据库连接失败: " . mysqli_connect_error()');
    }else{
        mysqli_select_db($link, 'message~board');
        $sql = "select * from user where username = '$user'";
        $res = mysqli_query($link, $sql);
        $row = mysqli_num_rows($res);
        if($row > 0){
            die('用户名已存在，请重新注册！');
        }else{
            $time = date('Y-m-d');
            $sql1 = "insert into user(username, password, phone, email, time) values('$user', '$pass', '$phone', '$email', '$time')";
            $res1 = mysqli_query($link, $sql1);
            if($res1){
                echo "注册成功，请返回登录！";
            }else{
                die('数据库异常，请稍后再试！');
            }
        }
    }
    mysqli_close($link);
}
?>