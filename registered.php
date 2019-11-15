<?php
session_start();
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

    $check_list = "/into|load_file|0x|outfile|by|substr|base|echo|hex|mid|like|or|char|union|or|select|greatest|%00|_|\'|KANAZAWA|limit|=_| |in|<|>|-|user|\.|\(\)|#|and|if|database|where|concat|insert|having|sleep|hex2bin|chr/i";
    $checks = ["$user", "$pass", "$res_pass", "$phone", "$email",];
    foreach($checks as $check){ ##此处膜拜Virink师傅那次的正则小考核，提供的思路
        preg_match("$check_list", $check, $m);
        if($m){
            die('SQL injection?');
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
}
?>