<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/12/4
 * Time: 16:28
 */
require_once('../connect.php');
//把传递过来的信息入库,在入库之前对所有的信息进行校验。
if(!(isset($_POST['update_rname'])&&(!empty($_POST['update_rname'])))){
    echo "<script>alert('读者名不能为空');window.location.href='reader.manage.php';</script>";
}
$Reader_id = $_POST['update_rno'];
$Reader_name = $_POST['update_rname'];
$sex = $_POST['update_sex'];
$birthday = $_POST['update_birthday'];
$password = $_POST['update_password'];
$phone = $_POST['update_phone'];
$mobile = $_POST['update_mobile'];
$Card_name = $_POST['update_card_name'];
$Card_id = $_POST['update_card_id'];
$level = $_POST['update_level'];
$day = date("Y-m-d",time());
$sql = "update readers set Reader_name='$Reader_name',sex='$sex',birthday='$birthday',password='$password',phone='$phone',mobile='$mobile',Card_name='$Card_name',Card_id='$Card_id',level='$level',day='$day' WHERE Reader_id='$Reader_id'";
echo $sql;
if(mysqli_query($con,$sql)){
    echo "<script>alert('修改读者成功');window.location.href='reader.manage.php?p=1';</script>";

}else{
    echo "<script>alert('修改读者失败');window.location.href='reader.manage.php?p=1';</script>";

}
?>