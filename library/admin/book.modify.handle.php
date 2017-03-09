<?php
require_once('../connect.php');
$Book_id = $_POST['update_Book_id'];
$Book_name = $_POST['update_Book_name'];
$author = $_POST['update_author'];
$publishing = $_POST['update_publishing'];
$Category_id = $_POST['update_Category'];
$price = $_POST['update_price'];
$date = date("Y-m-d", time());
$Quantity_in = $_POST['update_Quantity_in'];
$Quantity_out = $_POST['update_Quantity_out'];
$Quantity_loss = $_POST['update_Quantity_loss'];
	$updatesql = "update books set Book_name='$Book_name',author='$author',publishing='$publishing',Category_id='$Category_id',price='$price',Date_in='$date',Quantity_in='$Quantity_in',Quantity_out='$Quantity_out',Quantity_loss='$Quantity_loss' where Book_id='$Book_id'";
	if(mysqli_query($con,$updatesql)){
		echo "<script>alert('修改图书信息成功');window.location.href='book.manage.php?p=1';</script>";
	}else{
		echo "<script>alert('修改图书信息失败');window.location.href='book.manage.php?p=1';</script>";
	}
?>