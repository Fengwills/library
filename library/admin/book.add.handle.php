<?php
	require_once('../connect.php');
	//把传递过来的信息入库,在入库之前对所有的信息进行校验。
	if(!(isset($_POST['Book_name'])&&(!empty($_POST['Book_name'])))){
		echo "<script>alert('标题不能为空');window.location.href='article.add.php';</script>";
	}
	$Book_id=$_POST['Book_id'];
    $Book_name=$_POST['Book_name'];
    $author=$_POST['author'];
    $publishing=$_POST['publishing'];
    $Category_id=$_POST['Category_id'];
    $price=$_POST['price'];
    $date=date("Y-m-d",time());
    $Quantity_in=$_POST['Quantity_in'];
    $Quantity_out=$_POST['Quantity_out'];
    $Quantity_loss=$_POST['Quantity_loss'];
    $insertsql = "insert into books(Book_id,Book_name,author,publishing,Category_id,price,Date_in,Quantity_in,Quantity_out,Quantity_loss) values('$Book_id', '$Book_name','$author', '$publishing', '$Category_id', '$price','$date','$Quantity_in','$Quantity_out','$Quantity_loss')";
if(mysqli_query($con,$insertsql)){
echo "<script>alert('添加图书成功');window.location.href='book.manage.php?p=1';</script>";

}else{
    echo "<script>alert('添加图书失败');window.location.href='book.manage.php?p=1';</script>";

}
?>