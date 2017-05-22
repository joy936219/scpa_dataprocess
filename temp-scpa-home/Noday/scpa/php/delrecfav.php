<?php
include('connec.php');
session_start();

$school=$_POST["SchoolName"];
$department=$_POST["SchoolDepName"];
$Type=$_POST["Type"];
$user=$_SESSION['user'];
$sql=sprintf("DELETE FROM `recfav` WHERE `UserID`='%s' and `SchoolName` = '%s' and `SchoolDepName` = '%s' and `Type` = '%s'",mysql_real_escape_string($user),mysql_real_escape_string($school),mysql_real_escape_string($department),mysql_real_escape_string($Type));
if($result=$con->query($sql)===TRUE){
    echo "已從我的最愛中刪除。";
}else{
    echo "發生錯誤。";
}
$con->close();
?>