<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
session_start();
header("Content-type: text/html; charset=utf-8");
include("./moban/upload.html");


if(isset($_POST['submit']) && isset($_SESSION['uid'])){
    $img = $_FILES["file"]["name"];
    $_SESSION['imgname'] = $img;
    $whitelist = array("gif", "jpg", "png", "jpeg");
    $temp = explode(".", $img);
    $hz = end($temp);       // 获取文件后缀名
    $type = $_FILES["file"]["type"];

    if((($type == "image/gif") || ($type == "image/jpeg") || ($type == "image/jpg") || ($type == "image/pjpeg") || ($type == "image/x-png") || ($type == "image/png")) && ($_FILES["file"]["size"] < 204800) && in_array($hz, $whitelist)){
        if($_FILES["file"]["error"] > 0){
            echo "错误：：".$_FILES["file"]["error"];
            die;
        }
        $str = file_get_contents($_FILES["file"]["tmp_name"]);
        $dangerous = get_defined_functions();   //借鉴前几天的Nctf hacker_backdoor 这道题的waf
        array_push($dangerous["internal"], 'eval', 'assert', 'php'); 
        foreach($dangerous["internal"] as $bad){
            if(strpos($str, $bad) !== FALSE){
                die('你的文件有点东西呦！');
            }
        }
        if(file_exists("upload/".$img)){
            die('文件名重复，请重新上传！');
        }else{
            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/".$img);
            echo "<script>alert('上传成功！')</script>"."<meta http-equiv='Refresh'content='0;url=./index.php'/>";
        }
    }else{
        die("非法文件！！！");
    }
}

?>