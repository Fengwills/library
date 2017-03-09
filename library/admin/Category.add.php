<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/11/30
 * Time: 17:34
 */
require_once('../connect.php');
//把传递过来的信息入库,在入库之前对所有的信息进行校验。
if(!(isset($_POST['add_id'])&&(!empty($_POST['add_tname'])))){
    echo "<script>alert('标题不能为空');window.location.href='book.Category.php';</script>";
}
$Category_id = $_POST['add_id'];
$category = $_POST['add_tname'];
$insertsql = "insert into b_category(Category_id,category) values('$Category_id','$category')";
if(mysqli_query($con,$insertsql)){
    echo "<script>alert('添加分类成功');window.location.href='book.Category.php?p=1';</script>";

}else{

    echo "<script>alert('添加分类失败');window.location.href='article.Category.php?p=1';</script>";

}
?>