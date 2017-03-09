<?php
require_once('../connect.php');
$id = $_POST['delete_id'];
echo $id;
$deletesql = "delete from books where Book_id='$id'";
if(mysqli_query($con,$deletesql)){
echo "<script>alert('删除图书成功');window.location.href='book.manage.php?p=1';</script>";
}else{
echo "<script>alert('删除图书失败');window.location.href='book.manage.php?p=1';</script>";
}
?>