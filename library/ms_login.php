<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/11/27
 * Time: 22:39
 */
require_once ('connect.php');

//从bookmis数据库中提取数据
//查询是否是管理员
function collect_data($con,$name,$password){

    $sql = "select * from admin WHERE name='$name'and password = '$password'";
    $result = mysqli_query($con,$sql);

    $num= mysqli_num_rows($result);
    return $num;
}
//查询是否是读者
function collect_data2($con,$name,$password)
{
    $sql = "select Reader_id,password from readers WHERE Reader_id='$name'and password = '$password'";
    $result = mysqli_query($con,$sql);

    $num= mysqli_num_rows($result);
    return $num;
}

?>