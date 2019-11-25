<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>KANAZAWA的留言板</title>
    </head>
    <body>
        <div align="right">
            <?php
                session_start();
                $user = $_SESSION['username'];
                if(isset($_SESSION['uid']) && !isset($_SESSION['imgname'])){
                    echo "欢迎".$_SESSION['username']."来到KANAZAWA的留言板！";
                    echo "<br>";
                    echo "<a href = './upload.php'>修改头像</a>";
                    echo "<br>";
                    echo "<img width='64px' height='64px' src='upload/vk.png' />";
                    echo "<br>";
                    echo "<a href = 'changepasswd.php'>修改密码</a>";
                    echo "<br>";
                    echo "<a href = 'loginout.php'>注销</a>";
                }elseif(isset($_SESSION['uid']) && isset($_SESSION['imgname'])){
                    $imgname = $_SESSION['imgname'];
                    echo "欢迎".$_SESSION['username']."来到KANAZAWA的留言板！";
                    echo "<br>";
                    echo "<a href = './upload.php'>修改头像</a>";
                    echo "<br>";
                    echo "<img width='64px' height='64px' src='upload/$imgname' />";
                    echo "<br>";
                    echo "<a href = 'loginout.php'>注销</a>";
                }else{
                    die("<script>alert('请登录后再查看本页！')</script>"."<meta http-equiv='Refresh'content='0;url=./login.php'/>");
                }
            ?>
        </div>
        <center>
            <h1>KANAZAWA的留言板！</h1>
            <a href = "write.php">写留言</a>
            <h2>留言信息</h2>
            <table width="100%" border="1" cellpadding="0" cellspacing="0">
                <tr>
                    <th>序号</th>
                    <th>留言人</th>
                    <th>留言</th>
                    <th>时间</th>
                </tr>

                <?php
                    header("Content-type: text/html; charset=utf-8");

                    include("./DB.php");
                    mysqli_select_db($link, 'message~board');
                    $sql = "select * from message";
                    $res = mysqli_query($link, $sql);
                    while($row = mysqli_fetch_array($res)){
                        $message = "<tr>";
                        $message .= "<td>".$row['Id']."</td>";
                        $message .= "<td>".$row['username']."</td>";
                        $message .= "<td>".$row['text']."</td>";
                        $message .= "<td>".$row['time']."</td>";
                        echo $message;

                        $id = $row['Id'];
                        $user = $row['username'];
                        echo "<td><a href='./editor.php?id=".$id."'>修改</a>&nbsp&nbsp&nbsp<a href='./delete.php?id=".$id."'>删除</a></td>";
   	                    echo "</tr>";
                    }
                ?>
            </table>
        </center>
    </body>
</html>