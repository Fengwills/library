<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/11/30
* Time: 17:51
*/
require_once('../connect.php');
$Category_id = $_POST['update_id'];
$Category = $_POST['update_tname'];
$updatesql = "update b_category set category = '$Category' WHERE  Category_id='$Category_id'";
if(mysqli_query($con,$updatesql)){
echo "<script>alert('修改分类成功');window.location.href='book.Category.php?p=1';</script>";
}else{
echo "<script>alert('修改分类失败');window.location.href='book.Category.php?p=1';</script>";
}
?>
