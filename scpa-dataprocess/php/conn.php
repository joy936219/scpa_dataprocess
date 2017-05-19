<?php
   $server = "localhost";
   $username = "scpa";
   $password = "0813";
   $database ="scpa";

   $conn = mysqli_connect($server,$username,$password,$database);

   if($conn->connect_error){
   	  die("Connection failed:". $conn->connect_error);
   }
   mysql_query("SET NAMES 'UTF-8'");
?>