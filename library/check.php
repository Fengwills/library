<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/11/27
 * Time: 22:12
 */
require_once ("ms_login.php");
require_once 'connect.php';
$name=$_POST['name'];
$password=$_POST['password'];
$role=$_POST['role'];

    if($role==2)
    {
        $result=collect_data($con,$name,$password);
        if($result)
        {
            session_start();
            $_SESSION['name']=$name;
            header("Location: ./admin/library.index.php");//确保重定向后，后续代码不会被执行
            exit;
        }
        else

            //echo "密码错误<br>";
            echo"<script type='text/javascript'>alert('用户名或密码错误');location='login.html';</script>";
    }
    else
        $result=collect_data2($con,$name,$password);
        if($result)
        {
            session_start();
           $_SESSION['reader_id']=$name;
            header("Location: ./reader/reader.index.php");//确保重定向后，后续代码不会被执行
            exit;
        }
       else
           echo"<script type='text/javascript'>alert('用户名或密码错误');location='login.html';</script>";



?>