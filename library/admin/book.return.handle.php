<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/12/4
 * Time: 12:40
 */
require_once "../connect.php";
$Reader_id = $_POST['return_rno'];
$Book_id = $_POST['return_bno'];
if(!strcmp($Book_id,"")||!strcmp($Reader_id,""))
{
    echo "<script>alert('请输入图书编号和读者证号');window.location.href='book.return.php?p=1';</script>";

}
$selectsql = "select Date_borrow from borrow WHERE Book_id='$Book_id'and Reader_id = '$Reader_id'";
$query = mysqli_query($con,$selectsql);
$row =mysqli_fetch_assoc($query);
$Date_borrow  = $row['Date_borrow'];
$Date_return = date("Y-m-d",time());
$result = "result";
$sql = "set @$result = -1";
echo $sql;
mysqli_query($con,$sql);
$sql = "call ret('$Book_id','$Reader_id','$Date_borrow','$Date_return',@$result)";
echo $sql;
mysqli_query($con,$sql);
$sql = "select @$result";
echo $sql;
$query =mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($query);
echo $row['@result'];
if($row['@result'] == 1)
{
    echo "<script>alert('还书成功');window.location.href='book.return.php?p=1';</script>";

} else
{
    echo "<script>alert('还书失败,此读者不存在或此书不存在');window.location.href='book.return.php?p=1';</script>";
}
?>