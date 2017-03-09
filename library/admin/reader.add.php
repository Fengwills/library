<?php
require_once('../connect.php');
//把传递过来的信息入库,在入库之前对所有的信息进行校验。
if(!(isset($_POST['add_rname'])&&(!empty($_POST['add_rname'])))){
  echo "<script>alert('读者名不能为空');window.location.href='reader.manage.php?p=1';</script>";
}
$Reader_id = $_POST['add_rno'];
$Reader_name = $_POST['add_rname'];
$sex = $_POST['add_sex'];
$birthday = $_POST['add_birthday'];
$password = $_POST['add_password'];
$phone = $_POST['add_phone'];
$mobile = $_POST['add_mobile'];
$Card_name = $_POST['add_card_name'];
$Card_id = $_POST['add_card_id'];
$level = $_POST['add_level'];
$day = date("Y-m-d",time());
$insertsql = "insert into readers (Reader_id,Reader_name,sex,birthday,password,phone,mobile,Card_name,Card_id,level,day) values('$Reader_id', '$Reader_name','$sex', '$birthday', '$password', '$phone','$mobile','$Card_name','$Card_id','$level','$day')";
if(mysqli_query($con,$insertsql)){
  echo "<script>alert('添加读者成功');window.location.href='reader.manage.php?p=1';</script>";

}else{
  echo "<script>alert('添加读者失败');window.location.href='reader.manage.php?p=1';</script>";

}
?>