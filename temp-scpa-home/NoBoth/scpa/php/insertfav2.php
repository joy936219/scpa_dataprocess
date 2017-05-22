<?php
include('connec.php');
session_start();

$school=$_POST["schoolname"];
$department=$_POST["schooldepname"];
$Type=$_POST["Type"];
$user=$_SESSION['user'];
$index;
$index=0;
$sql1=sprintf("SELECT `OrderID` FROM volfav WHERE `UserID`='%s' ORDER BY `OrderID` DESC LIMIT 1",mysql_real_escape_string($user));
$result1=$con->query($sql1);
if($result1->num_rows>0){
    while($row1=$result1->fetch_assoc()){
        $index=$row1['OrderID'];
    }
}
$index++;
$sql=sprintf("INSERT INTO `volfav`(`UserID`, `SchoolName`, `SchoolDepName`,Type,OrderID) VALUES ('%s','%s','%s','%s',%d)",mysql_real_escape_string($user),mysql_real_escape_string($school),mysql_real_escape_string($department),mysql_real_escape_string($Type),mysql_real_escape_string($index));
if($result=$con->query($sql)===TRUE){
    echo "已加入我的最愛。";
}else{
    echo "發生錯誤。";
}
$con->close();
?>