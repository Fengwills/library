<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/12/10
 * Time: 20:56
 */
require_once "../connect.php";
$Reader_id = $_POST['return_rno'];
$Book_id = $_POST['return_bno'];
if(!strcmp($Book_id,"")||!strcmp($Reader_id,""))
{
    echo "<script>alert('请输入图书编号和读者证号');window.location.href='book.return.php?p=1';</script>";

}
$updatesql = "update books set Quantity_loss = Quantity_loss+1 WHERE Book_id = '$Book_id'";
$query = mysqli_query($con,$updatesql);
$sql = "delete from borrow WHERE Reader_id = '$Reader_id'AND Book_id ='$Book_id'";
$query2 = mysqli_query($con,$sql);
if($query&&$query2)
{
    echo "<script>alert('图书挂失成功');window.location.href='book.return.php?p=1';</script>";
}else
{
    echo "<script>alert('图书挂失失败');window.location.href='book.return.php?p=1';</script>";
}
?>