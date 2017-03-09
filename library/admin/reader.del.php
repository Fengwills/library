<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/12/4
 * Time: 16:53
 */
require_once('../connect.php');
$id = $_POST['delete_id'];
echo $id;
$deletesql = "delete from readers where Reader_id='$id'";
if(mysqli_query($con,$deletesql)){
    echo "<script>alert('删除读者成功');window.location.href='reader.manage.php?p=1';</script>";
}else{
    echo "<script>alert('删除读者失败');window.location.href='reader.manage.php?p=1';</script>";
}
?>