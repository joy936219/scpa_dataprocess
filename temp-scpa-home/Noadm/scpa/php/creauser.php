<?php
include("connec.php");
session_start();
$sql1="";
$sql2="";
$UserID="";
$LastName="";
$FirstName="";
$Password="";
$UserID=$_POST['UserID'];
$LastName=$_POST['LastName'];
$FirstName=$_POST['FirstName'];
$Password=$_POST['Password'];
$sql1=sprintf("SELECT * FROM `accounts` WHERE `UserID`='%s'",mysql_real_escape_string($UserID));
$result1=$con->query($sql1);
if($result1->num_rows==0){
    $sql2=sprintf("INSERT INTO `accounts`(`UserID`, `LastName`, `FirstName`, `Password`,AccountLevel) VALUES ('%s','%s','%s','%s',%d)",mysql_real_escape_string($UserID),mysql_real_escape_string($LastName),mysql_real_escape_string($FirstName),mysql_real_escape_string($Password),1);
    if($con->query($sql2) === TRUE){
        echo "OK";
    }else{
        echo "error";
    }
}else{
    echo "hasuser";
}

$con->close();
?>