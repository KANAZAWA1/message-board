<?php
    /*$dbservername = "localhost";
    $dbusername = "root";
    $dbpassword = "123456";
    //创建连接
    $link = mysqli_connect($dbservername, $dbusername, $dbpassword);*/



    class Db{
        //数据库连接对象
        private static $instance;
        private static $table_name;
        private static $pdo;
        //防止类直接实例化
        private static __construct(){
            $this->pdo = new PDO('mysql:host=localhost;dbname=message~board', 'root', '123456');
            $this->pdo->query('set names utf8');
        }
        //禁止克隆对象
        private function __clone(){}
        //返回数据库实例对象
        public static function getDb($table_name){

        }
    }
?>