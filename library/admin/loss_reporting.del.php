<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/12/10
 * Time: 19:27
 */
require_once('../connect.php');
$Reader_id = $_POST['delete_id'];
$delsql = "delete from loss_reporting WHERE Reader_id='$Reader_id'";
if(mysqli_query($con,$delsql)){
    echo "<script>alert('解除挂失成功');window.location.href='loss_reporting.php?p=1';</script>";
}else{
    echo "<script>alert('解除挂失失败');window.location.href='loss_reporting.php?p=1';</script>";
}
?>

