<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/12/1
 * Time: 20:38
 */
require_once "../connect.php";
$Reader_id = $_POST['borrow_rno'];
$Book_id = $_POST['borrow_bno'];
if(!strcmp($Book_id,"")||!strcmp($Reader_id,""))
{
    echo "<script>alert('请输入图书编号和读者证号');window.location.href='book.borrow.php?p=1';</script>";

}
$sql = "select * from readers WHERE Reader_id = '$Reader_id'";
$result = mysqli_query($con,$sql);
$num = mysqli_num_rows($result);
if($num == 0)
{
    echo "<script>alert('该读者证号不存在');window.location.href='book.borrow.php?p=1';</script>";
}
$sql = "select * from books WHERE Book_id = '$Book_id'";
$result = mysqli_query($con,$sql);
$num = mysqli_num_rows($result);
if($num == 0)
{
    echo "<script>alert('该图书不存在');window.location.href='book.borrow.php?p=1';</script>";
}

$sql = "select level from readers WHERE Reader_id='$Reader_id'";
$query = mysqli_query($con,$sql);
$row =mysqli_fetch_assoc($query);
$date_more = date("Y-m-d",time());

if(!strcmp($row['level'],"金卡"))
{
    $date_more = date('Y-m-d',strtotime('+90 day',strtotime(date("Y-m-d",time()))));
}else if(!strcmp($row['level'],"银卡"))
{
    $date_more = date('Y-m-d',strtotime('+60 day',strtotime($date_more)));
}else if(!strcmp($row['level'],"普通")){
    $date_more =  date('Y-m-d',strtotime('+30 day',strtotime($date_more)));
}


$date=date("Y-m-d",time());
$result = "result";
$sql = "set @$result = -1";
mysqli_query($con,$sql);
$sql = "CALL borr('$Reader_id','$Book_id','$date','$date_more',@$result)";
mysqli_query($con,$sql);
$sql = "Select @$result";
$query = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($query);
if($row['@result'] == 0)
{
    echo "<script>alert('借书失败,此读者今天已经借过此书');window.location.href='book.borrow.php?p=1';</script>";
}
else if($row['@result'] == 1)
{
    echo "<script>alert('借书失败,此书没有余量');window.location.href='book.borrow.php?p=1';</script>";
}else if($row['@result'] == 2)
{
    echo "<script>alert('借书失败,该读者读者证丢失');window.location.href='book.borrow.php?p=1';</script>";
}else if($row['@result']==3)
{
    echo "<script>alert('借书失败,该读者借书数达到上限');window.location.href='book.borrow.php?p=1';</script>";
}else if($row['@result']==4)
{
    echo "<script>alert('借书失败,该读者借过此书还未还');window.location.href='book.borrow.php?p=1';</script>";
} else{
    echo "<script>alert('借书成功');window.location.href='book.borrow.php?p=1';</script>";

}
?>