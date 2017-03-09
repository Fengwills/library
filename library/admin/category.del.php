<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/11/30
 * Time: 17:57
 */
require_once('../connect.php');
$Category_id = $_POST['delete_id'];
$delsql = "delete from b_category WHERE Category_id='$Category_id'";
if(mysqli_query($con,$delsql)){
    echo "<script>alert('删除分类成功');window.location.href='book.Category.php?p=1';</script>";
}else{
    echo "<script>alert('删除分类失败');window.location.href='book.Category.php?p=1';</script>";
}
?>