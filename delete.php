<!DOCTYPE html>
<html>
    <head>
        <title>KANAZAWA的留言删除页面</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        
        <?php
        session_start();
        include("./DB.php");

        if(!isset($_SESSION['uid']))
        die("<script>alert('请登录后再查看本页！')</script>"."<meta http-equiv='Refresh'content='0;url=./login.php'/>");

        $id = $_GET['id'];

        mysqli_select_db($link, 'message~board');
        $sql = "select * from message where Id = '$id'";
        $res = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($res);
        //var_dump($sql);die;
        if($row['username'] !== $_SESSION['username']){
         die("<script>alert('您无法删除他人留言！')</script>"."<meta http-equiv='Refresh'content='0;url=./index.php'/>");
        }

        $sql1 = "delete from message where id='$id'";
        $res1 = mysqli_query($link, $sql1);
        if($res1){
            echo "<script>alert('删除成功！')</script>"."<meta http-equiv='Refresh'content='0;url=./index.php'/>";
        }else{
            die('数据库异常，请稍后再试！');
        }
    
        mysqli_close($link);
        }
        ?>

    </body>
</html>