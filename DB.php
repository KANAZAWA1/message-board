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
            self::$table_name = $table_name;
            //判断如果静态属性中是否有类对象  如果没有则，实例化该类 赋予 静态属性
            //如此开辟了一块静态空间用来存储实例化对象 类外只需调用一次即可 节省了资源
            if(!(self::$instance instanceof self)){
                self::$instance = new self;
            }
            return self::$instance;
        }
        //添加数据
        function fb($table_name, $data){
            $keys = implode(',', array_keys($data));
            $value = "'".implode("','", array_values($data))."'";
            $sql = "insert into $table_name ($keys) values($value)";
            $r = $this->pdo->exec($sql);
            $this->getErrorInfo();
            return $r;
        }
    }
?>