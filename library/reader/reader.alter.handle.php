<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/12/6
 * Time: 21:45
 */
require_once "../connect.php";
session_start();
$Reader_id = $_SESSION['reader_id'];

$Reader_name = $_POST['update_rname'];
$password = $_POST['update_password'];
$new_password = $_POST['update_password_new'];
$confirm_passpwrd = $_POST['update_password_confirm'];
if(strcmp($new_password,$confirm_passpwrd))
{
    echo "<script>alert('两次输入的新密码不一致');window.location.href='./reader.alter.php';</script>";
}
$sql = "select password from readers WHERE Reader_id = '$Reader_id'";
$query = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($query);
if(!strcmp($row['password'],$password))
{
    echo "<script>alert('原密码错误');window.location.href='./reader.alter.php';</script>";
}
$sql = "update readers set password = '$new_password' WHERE Reader_id = '$Reader_id'";
if(mysqli_query($con,$sql))
{
    echo "<script>alert('修改密码成功');window.location.href='./reader.alter.php';</script>";
}else{
   echo "<script>alert('修改密码失败');window.location.href='./reader.alter.php';</script>";
}
?>