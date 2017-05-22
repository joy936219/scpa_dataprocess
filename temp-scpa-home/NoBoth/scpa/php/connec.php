<?php
//建立連線
$con=new mysqli("localhost","scpa","0813","scpa");
if($con->connect_error){
    die("Connection failed: ".$con->connect_error);
}
mysql_query("SET NAMES 'UTF-8'");
header('Access-Control-Allow-Origin: *');
?>