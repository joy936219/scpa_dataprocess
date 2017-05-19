<?php
include("conn.php");
session_start();
$sql1="";
$sql2="";
$user=$_SESSION['userid'];
$password=$_POST["Password"];
$newPassword=$_POST["newPassword"];

$sql1=sprintf("SELECT Password FROM `accounts` WHERE UserID='%s' and Password='%s'",mysql_real_escape_string($user),mysql_real_escape_string($password));
$result1=$conn->query($sql1);
if($result1->num_rows>0){
    $sql2=sprintf("UPDATE `accounts` SET `Password`='%s' WHERE `UserID`='%s'",mysql_real_escape_string($newPassword),mysql_real_escape_string($user));
    
    if($conn->query($sql2) === TRUE){
        echo "OK";
    }else{
        echo "Error";
    }
}else{
    echo "NO";
}

$conn->close();
?>