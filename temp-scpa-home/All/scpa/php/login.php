<?php
include("connec.php");
session_start();

$user=$_POST["user"];
$password=$_POST["password"];
$sql=sprintf("SELECT * FROM `Accounts` where UserID='%s' and Password='%s' and AccountLevel=%d",mysql_real_escape_string($user),mysql_real_escape_string($password),2);
$result = $con->query($sql);
if($result->num_rows > 0){
    $_SESSION['user']=$user;
    echo "Login";
}else{
    echo "Error";
}
$con->close();
?>