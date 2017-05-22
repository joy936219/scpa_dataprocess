<?php
include('connec.php');
session_start();

$school=$_POST["schoolname"];
$department=$_POST["schooldepname"];
$Type=$_POST["Type"];
$user=$_SESSION['user_try'];
$sql=sprintf("INSERT INTO `recfav`(`UserID`, `SchoolName`, `SchoolDepName`,Type) VALUES ('%s','%s','%s','%s')",mysql_real_escape_string($user),mysql_real_escape_string($school),mysql_real_escape_string($department),mysql_real_escape_string($Type));
if($result=$con->query($sql)===TRUE){
    echo "已加入我的最愛。";
}else{
    echo "發生錯誤。";
}
$con->close();
?>