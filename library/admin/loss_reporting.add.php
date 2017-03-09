<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/12/10
 * Time: 19:06
 */
require_once "../connect.php";
$Reader_id = $_POST['add_id'];
$loss_date = $_POST['add_tdate'];
$sql = "insert into loss_reporting(Reader_id,Loss_date)VALUE('$Reader_id','$loss_date')";
if(mysqli_query($con,$sql)){
    echo "<script>alert('挂失成功');window.location.href='loss_reporting.php?p=1';</script>";

}else{
    echo "<script>alert('挂失失败');window.location.href='loss_reporting.php?p=1';</script>";
}
?>

