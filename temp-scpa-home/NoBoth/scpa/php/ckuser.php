<?php
include("connec.php");
session_start();

$user=$_SESSION['user'];
$sql=sprintf("SELECT * FROM `Accounts` where UserID='%s'",mysql_real_escape_string($user));
$result = $con->query($sql);
if($result->num_rows > 0){
    echo "Login";
}else{
    echo "";
}
$con->close();
?>