<!DOCTYPE html>
<html>
    <head>
        <title>KANAZAWA的留言修改页面</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        
        <?php
        session_start();
        include("./DB.php");

        if(!isset($_SESSION['uid']))
        die("请登录后再查看本页！"."<meta http-equiv='Refresh'content='3;url=./login.php'/>");

        $id = $_GET['id'];
        $text = $_POST['text'];
        echo "        
        <center>
        <form action='./editor.php?id=$id' method='POST' >
            </br>
            <h3>KANAZAWA的留言修改页面</h3>
            请输入你的新留言内容:
            </br></br>
            <textarea name='text' rows='8' cols='80'></textarea>
            </br></br>
            <input type='submit' name='submit' value='修  改' >
            <p style='width: 200px;display: inline-block;'></p>
            
        </form>
        </center>";

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
        //var_dump($sql);die;
        if($row['username'] !== $_SESSION['username']){
         die("<script>alert('您无法修改他人留言！')</script>"."<meta http-equiv='Refresh'content='0;url=./index.php'/>");
        }

        $sql1 = "update message set text='$text' where Id='$id'";
        $res1 = mysqli_query($link, $sql1);
        if($res1){
            echo "<script>alert('修改成功！')</script>"."<meta http-equiv='Refresh'content='0;url=./index.php'/>";
        }else{
            die('数据库异常，请稍后再试！');
        }
    
        mysqli_close($link);
        }
        ?>

    </body>
</html>