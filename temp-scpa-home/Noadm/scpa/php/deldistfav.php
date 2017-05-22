<?php
include('connec.php');
session_start();

$school=$_POST["SchoolName"];
$department=$_POST["SchoolDepName"];
$Type=$_POST["Type"];
$OrderID=$_POST["OrderID"];
$user=$_SESSION['user'];
$sql1=sprintf("SELECT * FROM volfav WHERE `UserID`='%s' AND `OrderID`>%d",mysql_real_escape_string($user),mysql_real_escape_string($OrderID));
$result1=$con->query($sql1);
if($result1->num_rows>0){
    while($row1=$result1->fetch_assoc()){
        $sql2=sprintf("UPDATE volfav SET `OrderID`=%d WHERE `UserID`='%s' AND `SchoolName`='%s' AND `SchoolDepName`='%s' AND `Type`='%s'",mysql_real_escape_string($row1['OrderID']-1),mysql_real_escape_string($user),mysql_real_escape_string($row1['SchoolName']),mysql_real_escape_string($row1['SchoolDepName']),mysql_real_escape_string($row1['Type']));
        $con->query($sql2);
    }
}
$sql=sprintf("DELETE FROM `volfav` WHERE `UserID`='%s' and `SchoolName` = '%s' and `SchoolDepName` = '%s' and `Type` = '%s'",mysql_real_escape_string($user),mysql_real_escape_string($school),mysql_real_escape_string($department),mysql_real_escape_string($Type));
if($result=$con->query($sql)===TRUE){
    echo "已從我的最愛中刪除。";
}else{
    echo "發生錯誤。";
}
$con->close();
?>